<?php

namespace App\Services;

use App\Models\Application;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ApplicationDocumentService
{
    protected WordTemplateService $wordService;
    protected ExcelTemplateService $excelService;

    public function __construct(WordTemplateService $wordService, ExcelTemplateService $excelService)
    {
        $this->wordService = $wordService;
        $this->excelService = $excelService;
    }

    /**
     * Generate both documents for an application
     */
    public function generateDocuments(Application $application): array
    {
        try {
            // Delete old documents if they exist
            $oldDocuments = $application->documents ?? [];
            if (isset($oldDocuments['word']) && Storage::exists($oldDocuments['word'])) {
                Storage::delete($oldDocuments['word']);
            }
            if (isset($oldDocuments['excel']) && Storage::exists($oldDocuments['excel'])) {
                Storage::delete($oldDocuments['excel']);
            }

            // Generate new documents
            $wordPath = $this->wordService->generate($application);
            $excelPath = $this->excelService->generate($application);

            // Update application documents field
            $documents = [
                'word' => $wordPath,
                'excel' => $excelPath,
            ];
            
            $application->update(['documents' => $documents]);

            Log::info("Documents generated successfully for application {$application->id}");

            return [
                'word' => $wordPath,
                'excel' => $excelPath,
            ];
        } catch (\Exception $e) {
            Log::error("Document generation failed for application {$application->id}: " . $e->getMessage());
            throw $e;
        }
    }
}

