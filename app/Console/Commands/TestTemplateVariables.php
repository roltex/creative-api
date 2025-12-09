<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpWord\TemplateProcessor;

class TestTemplateVariables extends Command
{
    protected $signature = 'test:template-variables';
    protected $description = 'Test what variables are in the Word template';

    public function handle()
    {
        $templatePath = storage_path('app/templates/application_template.docx');
        
        if (!file_exists($templatePath)) {
            $this->error('Template not found');
            return 1;
        }

        try {
            $template = new TemplateProcessor($templatePath);
            $variables = $template->getVariables();
            
            $this->info('Found ' . count($variables) . ' variables:');
            foreach ($variables as $var) {
                $this->line('  - ${' . $var . '}');
            }
            
            return 0;
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }
}

