<?php

namespace App\Services;

use App\Models\Application;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class WordTemplateService
{
    /**
     * Generate Word document from template
     */
    public function generate(Application $application): string
    {
        $templatePath = storage_path('app/templates/application_template.docx');
        
        if (!file_exists($templatePath)) {
            throw new \Exception('Word template not found at: ' . $templatePath);
        }

        try {
            // Load the template using TemplateProcessor
            $templateProcessor = new TemplateProcessor($templatePath);
            $formData = $application->form_data ?? [];

            // Extract and set all simple variables
            $this->setSimpleVariables($templateProcessor, $formData);

            // Clone repeatable sections
            $this->processRepeatableSections($templateProcessor, $formData);

            // Save the generated document
            $fileName = 'application_' . $application->id . '_' . time() . '.docx';
            $filePath = storage_path('app/applications/' . $fileName);
            
            // Ensure directory exists
            $dir = dirname($filePath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            $templateProcessor->saveAs($filePath);

            return 'applications/' . $fileName;
        } catch (\Exception $e) {
            Log::error('Word document generation error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            throw new \Exception('Failed to generate Word document: ' . $e->getMessage());
        }
    }

    /**
     * Set all simple (non-repeatable) variables
     */
    private function setSimpleVariables(TemplateProcessor $templateProcessor, array $formData): void
    {
        $applicantType = $formData['applicantType'] ?? 'individual';
        
        // Get all variables in template to avoid errors
        $templateVars = $templateProcessor->getVariables();
        
        // Helper function to safely set value
        $safeSetValue = function($var, $value) use ($templateProcessor, $templateVars) {
            if (in_array($var, $templateVars)) {
                // Replace empty values with space to avoid showing placeholder text
                $templateProcessor->setValue($var, $value !== '' ? $value : ' ');
            }
        };
        
        // Project info
        $safeSetValue('competitionTitle', $formData['competitionTitle'] ?? '');
        $safeSetValue('projectName', $formData['title'] ?? '');
        $safeSetValue('requestedAmount', number_format($formData['requestedAmountGel'] ?? 0, 2, '.', ''));
        $safeSetValue('startDate', isset($formData['startDate']) ? Carbon::parse($formData['startDate'])->format('d.m.Y') : '');
        $safeSetValue('endDate', isset($formData['endDate']) ? Carbon::parse($formData['endDate'])->format('d.m.Y') : '');
        
        // Applicant info - Legal Entity
        if ($applicantType === 'legal_entity') {
            $safeSetValue('orgName', $formData['orgName'] ?? '');
            $safeSetValue('orgIdCode', $formData['orgIdCode'] ?? '');
            $safeSetValue('orgHead', $formData['orgHead'] ?? '');
            $safeSetValue('orgAddress', $formData['orgAddress'] ?? '');
            $safeSetValue('orgPhone', $formData['orgPhone'] ?? '');
            $safeSetValue('orgEmail', $formData['orgEmail'] ?? '');
            
            // Clear individual fields
            $safeSetValue('personFullName', '');
            $safeSetValue('personIdNumber', '');
            $safeSetValue('personAddress', '');
            $safeSetValue('personPhone', '');
        } else {
            // Individual
            $safeSetValue('personFullName', $formData['personFullName'] ?? '');
            $safeSetValue('personIdNumber', $formData['personIdNumber'] ?? '');
            $safeSetValue('personAddress', $formData['address'] ?? '');
            $safeSetValue('personPhone', $formData['personPhone'] ?? '');
            
            // Clear legal entity fields
            $safeSetValue('orgName', '');
            $safeSetValue('orgIdCode', '');
            $safeSetValue('orgHead', '');
            $safeSetValue('orgAddress', '');
            $safeSetValue('orgPhone', '');
            $safeSetValue('orgEmail', '');
        }
        
        // Contact person
        $safeSetValue('contactFullName', $formData['contactFullName'] ?? '');
        $safeSetValue('contactPersonalId', $formData['contactPersonalId'] ?? '');
        $safeSetValue('contactPhone', $formData['contactPhone'] ?? '');
        $safeSetValue('contactEmail', $formData['contactEmail'] ?? '');
        
        // Cofunder (first one only for simple variable)
        $cofunders = $formData['cofunders'] ?? [];
        if (!empty($cofunders) && isset($cofunders[0])) {
            $safeSetValue('cofunderName', $cofunders[0]['name'] ?? '');
            $safeSetValue('cofunderIdCode', $cofunders[0]['idCode'] ?? '');
            $safeSetValue('cofunderHead', $cofunders[0]['head'] ?? '');
            $safeSetValue('cofunderAddress', $cofunders[0]['address'] ?? '');
            $safeSetValue('cofunderPhone', $cofunders[0]['phone'] ?? '');
            $safeSetValue('cofunderEmail', $cofunders[0]['email'] ?? '');
        } else {
            $safeSetValue('cofunderName', '');
            $safeSetValue('cofunderIdCode', '');
            $safeSetValue('cofunderHead', '');
            $safeSetValue('cofunderAddress', '');
            $safeSetValue('cofunderPhone', '');
            $safeSetValue('cofunderEmail', '');
        }
        
        // Budget
        $safeSetValue('totalBudget', number_format($formData['totalBudgetGel'] ?? 0, 2, '.', ''));
        $safeSetValue('requestedFromCreativeGeorgia', number_format($formData['requestedFromCreativeGeorgia'] ?? 0, 2, '.', ''));
        $safeSetValue('selfFunding', number_format($formData['selfFundingGel'] ?? 0, 2, '.', ''));
        $safeSetValue('coFunding', number_format($formData['coFundingGel'] ?? 0, 2, '.', ''));
        
        // Text sections
        $safeSetValue('projectDescription', $formData['projectDescription'] ?? '');
        $safeSetValue('evaluationCriteria', $formData['evaluationCriteria'] ?? '');
        $safeSetValue('experience', $formData['experience'] ?? '');
        
        // Submission date and year
        $safeSetValue('submissionDate', Carbon::now()->format('d.m.Y'));
        $safeSetValue('year', Carbon::now()->format('Y'));
        $safeSetValue('submissionYear', Carbon::now()->format('Y'));
    }

    /**
     * Process repeatable sections (stages)
     */
    private function processRepeatableSections(TemplateProcessor $templateProcessor, array $formData): void
    {
        // Process stages (repeatable rows in table)
        $stages = $formData['stages'] ?? [];
        
        if (!empty($stages) && count($stages) > 0) {
            // Clone the row for each stage
            $templateProcessor->cloneRow('stageNumber', count($stages));
            
            foreach ($stages as $index => $stage) {
                $rowIndex = $index + 1;
                
                $templateProcessor->setValue('stageNumber#' . $rowIndex, $rowIndex);
                $templateProcessor->setValue('stageName#' . $rowIndex, $stage['name'] ?? '');
                $templateProcessor->setValue('stageAssignee#' . $rowIndex, $stage['assignee'] ?? '');
                
                $dates = '';
                if (!empty($stage['startDate']) && !empty($stage['endDate'])) {
                    $start = Carbon::parse($stage['startDate'])->format('d.m.Y');
                    $end = Carbon::parse($stage['endDate'])->format('d.m.Y');
                    $dates = $start . ' - ' . $end;
                }
                $templateProcessor->setValue('stageDates#' . $rowIndex, $dates);
                $templateProcessor->setValue('stageLocation#' . $rowIndex, $stage['location'] ?? '');
            }
        } else {
            // If no stages, set empty values
            $templateProcessor->setValue('stageNumber', '');
            $templateProcessor->setValue('stageName', '');
            $templateProcessor->setValue('stageAssignee', '');
            $templateProcessor->setValue('stageDates', '');
            $templateProcessor->setValue('stageLocation', '');
        }
    }
}

