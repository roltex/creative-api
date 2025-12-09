<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Application;
use App\Services\ApplicationDocumentService;

class RegenerateDocuments extends Command
{
    protected $signature = 'documents:regenerate {application_id}';
    protected $description = 'Regenerate documents for a specific application';

    public function handle(ApplicationDocumentService $documentService)
    {
        $applicationId = $this->argument('application_id');
        
        $application = Application::find($applicationId);
        
        if (!$application) {
            $this->error("Application with ID {$applicationId} not found.");
            return 1;
        }

        $this->info("Generating documents for application {$application->id}...");
        
        try {
            $documents = $documentService->generateDocuments($application);
            
            $this->info("Documents generated successfully!");
            $this->info("Word document: {$documents['word']}");
            $this->info("Excel document: {$documents['excel']}");
            
            return 0;
        } catch (\Exception $e) {
            $this->error("Failed to generate documents: " . $e->getMessage());
            $this->error($e->getTraceAsString());
            return 1;
        }
    }
}

