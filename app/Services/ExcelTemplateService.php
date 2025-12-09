<?php

namespace App\Services;

use App\Models\Application;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Facades\Log;

class ExcelTemplateService
{
    // Map frontend category keys to Excel row positions and Georgian names
    private const CATEGORY_MAP = [
        'labor' => ['row' => 13, 'name' => 'შრომის ანაზღაურება', 'number' => 1],
        'honorarium' => ['row' => 18, 'name' => 'მონაწილეთა ჰონორარები', 'number' => 2],
        'transport' => ['row' => 23, 'name' => 'სატრანსპორტო ხარჯები', 'number' => 3],
        'living' => ['row' => 28, 'name' => 'ცხოვრების ხარჯი', 'number' => 4],
        'rent' => ['row' => 33, 'name' => 'იჯარა', 'number' => 5],
        'exhibition' => ['row' => 38, 'name' => 'საექსპოზიციო/სადადგმო ხარჯი', 'number' => 6],
        'printing' => ['row' => 43, 'name' => 'ბეჭდვის ხარჯი', 'number' => 7],
        'other' => ['row' => 48, 'name' => 'სხვა მომსახურება/ხარჯი', 'number' => 8],
    ];

    /**
     * Generate Excel document from template
     */
    public function generate(Application $application): string
    {
        $templatePath = storage_path('app/templates/application_template.xlsx');
        
        if (!file_exists($templatePath)) {
            throw new \Exception('Excel template not found at: ' . $templatePath);
        }

        try {
            // Load the template
            $spreadsheet = IOFactory::load($templatePath);
            $sheet = $spreadsheet->getActiveSheet();
            $formData = $application->form_data ?? [];

            // Fill static fields
            $this->fillStaticFields($sheet, $formData);

            // Process expense categories
            $this->processExpenseCategories($sheet, $formData['expenseCategories'] ?? []);

            // Update totals
            $this->updateTotals($sheet);

            // Save the generated document
            $fileName = 'application_' . $application->id . '_' . time() . '.xlsx';
            $filePath = storage_path('app/applications/' . $fileName);
            
            // Ensure directory exists
            $dir = dirname($filePath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save($filePath);

            return 'applications/' . $fileName;
        } catch (\Exception $e) {
            Log::error('Excel document generation error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            throw new \Exception('Failed to generate Excel document: ' . $e->getMessage());
        }
    }

    /**
     * Fill static fields - Replace placeholders in ALL cells throughout the worksheet
     */
    private function fillStaticFields($sheet, array $formData): void
    {
        $applicantType = $formData['applicantType'] ?? 'individual';
        
        // Prepare replacement values
        $replacements = [
            '${projectName}' => $formData['title'] ?? '',
            '${submissionDate}' => \Carbon\Carbon::now()->format('d.m.Y'),
        ];
        
        // Applicant-specific replacements
        if ($applicantType === 'legal_entity') {
            $replacements['${orgName}'] = $formData['orgName'] ?? '';
            $replacements['${orgIdCode}'] = $formData['orgIdCode'] ?? '';
            // Remove individual placeholders
            $replacements['${personFullName}'] = '';
            $replacements['${personIdNumber}'] = '';
        } else {
            $replacements['${personFullName}'] = $formData['personFullName'] ?? '';
            $replacements['${personIdNumber}'] = $formData['personIdNumber'] ?? '';
            // Remove legal entity placeholders
            $replacements['${orgName}'] = '';
            $replacements['${orgIdCode}'] = '';
        }
        
        // Scan all cells in the worksheet and replace placeholders
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        
        foreach ($sheet->getRowIterator() as $row) {
            foreach ($row->getCellIterator() as $cell) {
                $cellValue = $cell->getValue();
                
                // Only process string values that contain placeholders
                if (is_string($cellValue) && str_contains($cellValue, '${')) {
                    // Replace all placeholders in this cell
                    foreach ($replacements as $placeholder => $value) {
                        $cellValue = str_replace($placeholder, $value, $cellValue);
                    }
                    
                    // Clean up extra spaces
                    $cellValue = preg_replace('/\s+/', ' ', $cellValue);
                    $cellValue = trim($cellValue);
                    
                    // Set the updated value
                    $cell->setValue($cellValue);
                }
            }
        }
    }

    /**
     * Process all expense categories - Find template rows and clone them
     */
    private function processExpenseCategories($sheet, array $expenseCategories): void
    {
        // Process from bottom to top to avoid row number issues when inserting
        $categoryKeys = array_reverse(array_keys(self::CATEGORY_MAP));
        
        foreach ($categoryKeys as $categoryKey) {
            $expenses = $expenseCategories[$categoryKey] ?? [];
            $categoryInfo = self::CATEGORY_MAP[$categoryKey];
            $categoryNumber = $categoryInfo['number'];
            
            // Find the template row (the one with ${expenseName})
            $templateRow = $this->findTemplateRow($sheet, $categoryInfo['name']);
            
            if ($templateRow === null) {
                continue; // Skip if template row not found
            }
            
            $expenseCount = count($expenses);
            
            if ($expenseCount > 0) {
                // Insert (expenseCount - 1) new rows after the template row
                // This pushes all rows below down
                for ($i = 1; $i < $expenseCount; $i++) {
                    $sheet->insertNewRowBefore($templateRow + 1, 1);
                    // Copy the template row to the new row
                    $this->copyRow($sheet, $templateRow, $templateRow + $i);
                }
                
                // Now fill all expense rows (template row + cloned rows)
                for ($i = 0; $i < $expenseCount; $i++) {
                    $this->fillExpenseRow($sheet, $templateRow + $i, $categoryNumber, $i + 1, $expenses[$i]);
                }
                
            } else {
                // If no expenses, clear the template row
                for ($col = 'A'; $col <= 'I'; $col++) {
                    $sheet->setCellValue($col . $templateRow, '');
                }
            }
        }
    }
    
    /**
     * Find the template row for a category
     */
    private function findTemplateRow($sheet, string $categoryName): ?int
    {
        $highestRow = $sheet->getHighestRow();
        
        for ($row = 1; $row <= $highestRow; $row++) {
            $cellB = $sheet->getCell('B' . $row)->getValue();
            
            // Look for ${expenseName} placeholder
            if (is_string($cellB) && str_contains($cellB, '${expenseName}')) {
                // Verify this is the right category by checking previous rows
                for ($checkRow = max(1, $row - 3); $checkRow < $row; $checkRow++) {
                    $checkValue = $sheet->getCell('B' . $checkRow)->getValue();
                    if (is_string($checkValue) && str_contains($checkValue, $categoryName)) {
                        return $row;
                    }
                }
            }
        }
        
        return null;
    }
    
    /**
     * Copy a row to another row
     */
    private function copyRow($sheet, int $sourceRow, int $targetRow): void
    {
        for ($col = 'A'; $col <= 'I'; $col++) {
            $sourceCell = $sheet->getCell($col . $sourceRow);
            $targetCell = $sheet->getCell($col . $targetRow);
            
            // Copy value
            $targetCell->setValue($sourceCell->getValue());
            
            // Copy style
            $targetCell->setXfIndex($sourceCell->getXfIndex());
        }
        
        // Copy row height
        $sheet->getRowDimension($targetRow)->setRowHeight(
            $sheet->getRowDimension($sourceRow)->getRowHeight()
        );
    }

    /**
     * Fill a single expense row - Replace placeholders in all columns
     */
    private function fillExpenseRow($sheet, int $row, int $categoryNumber, int $itemNumber, array $expense): void
    {
        // Prepare replacement map
        $replacements = [
            '${expenseName}' => $expense['name'] ?? '',
            '${unit}' => $expense['unit'] ?? '',
            '${quantity}' => is_numeric($expense['quantity'] ?? 0) ? floatval($expense['quantity']) : 0,
            '${unitPrice}' => is_numeric($expense['unitPrice'] ?? 0) ? floatval($expense['unitPrice']) : 0,
            '${total}' => (is_numeric($expense['quantity'] ?? 0) ? floatval($expense['quantity']) : 0) * (is_numeric($expense['unitPrice'] ?? 0) ? floatval($expense['unitPrice']) : 0),
            '${creativeGeorgiaAmount}' => is_numeric($expense['creativeGeorgiaAmount'] ?? 0) ? floatval($expense['creativeGeorgiaAmount']) : 0,
            '${selfFunding}' => is_numeric($expense['selfFunding'] ?? 0) ? floatval($expense['selfFunding']) : 0,
            '${otherFunding}' => is_numeric($expense['otherFunding'] ?? 0) ? floatval($expense['otherFunding']) : 0,
        ];

        // Iterate through all columns in this row and replace placeholders
        foreach (range('A', 'I') as $col) {
            $cell = $sheet->getCell($col . $row);
            $cellValue = $cell->getValue();
            
            // Special handling for column A (item number)
            if ($col === 'A') {
                $sheet->setCellValue('A' . $row, $categoryNumber . '.' . $itemNumber);
                continue;
            }
            
            // Replace placeholders if cell contains them
            if (is_string($cellValue) && str_contains($cellValue, '${')) {
                foreach ($replacements as $placeholder => $value) {
                    $cellValue = str_replace($placeholder, (string)$value, $cellValue);
                }
                $cell->setValue($cellValue);
            } else {
                // If no placeholder, just set the value directly based on column
                switch ($col) {
                    case 'B':
                        $cell->setValue($expense['name'] ?? '');
                        break;
                    case 'C':
                        $cell->setValue($expense['unit'] ?? '');
                        break;
                    case 'D':
                        $cell->setValue($replacements['${quantity}']);
                        break;
                    case 'E':
                        $cell->setValue($replacements['${unitPrice}']);
                        break;
                    case 'F':
                        $cell->setValue($replacements['${total}']);
                        break;
                    case 'G':
                        $cell->setValue($replacements['${creativeGeorgiaAmount}']);
                        break;
                    case 'H':
                        $cell->setValue($replacements['${selfFunding}']);
                        break;
                    case 'I':
                        $cell->setValue($replacements['${otherFunding}']);
                        break;
                }
            }
        }

        // Apply formatting
        $this->applyRowFormatting($sheet, $row);
    }

    /**
     * Apply formatting to a row
     */
    private function applyRowFormatting($sheet, int $row): void
    {
        // Apply borders
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        
        $sheet->getStyle('A' . $row . ':I' . $row)->applyFromArray($styleArray);

        // Format number columns
        $sheet->getStyle('D' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('H' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
    }

    /**
     * Clear a row
     */
    private function clearRow($sheet, int $row): void
    {
        foreach (range('A', 'I') as $col) {
            $sheet->setCellValue($col . $row, '');
        }
    }

    /**
     * Update total formulas and submission date
     */
    private function updateTotals($sheet): void
    {
        // Find the totals row (should be after all expenses)
        $lastRow = $sheet->getHighestRow();
        
        // Look for the "ჯამი" (Total) row
        $totalsRow = null;
        for ($row = 10; $row <= $lastRow; $row++) {
            $cellValue = $sheet->getCell('B' . $row)->getValue();
            if (is_string($cellValue) && str_contains($cellValue, 'ჯამი')) {
                $totalsRow = $row;
                break;
            }
        }
        
        if ($totalsRow === null) {
            return; // Totals row not found
        }
        
        // First expense row is ALWAYS row 13
        $firstExpenseRow = 13;
        
        // The last expense row is the row BEFORE the totals row (ჯამი - 1)
        $lastExpenseRow = $totalsRow - 1;
        
        // Set the SUM formulas in columns F, G, H, I for the ჯამი row
        $sheet->setCellValue('F' . $totalsRow, '=SUM(F' . $firstExpenseRow . ':F' . $lastExpenseRow . ')');
        $sheet->setCellValue('G' . $totalsRow, '=SUM(G' . $firstExpenseRow . ':G' . $lastExpenseRow . ')');
        $sheet->setCellValue('H' . $totalsRow, '=SUM(H' . $firstExpenseRow . ':H' . $lastExpenseRow . ')');
        $sheet->setCellValue('I' . $totalsRow, '=SUM(I' . $firstExpenseRow . ':I' . $lastExpenseRow . ')');
        
        // Set submission date (find the cell with the placeholder or go 8 rows below)
        for ($row = $totalsRow; $row <= $lastRow; $row++) {
            $cellValue = $sheet->getCell('C' . $row)->getValue();
            if (is_string($cellValue) && str_contains($cellValue, '${submissionDate}')) {
                $sheet->setCellValue('C' . $row, \Carbon\Carbon::now()->format('d.m.Y'));
                break;
            }
        }
    }
}

