<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Application;

class ShowApplicationData extends Command
{
    protected $signature = 'show:application-data {id}';
    protected $description = 'Show application form data';

    public function handle()
    {
        $id = $this->argument('id');
        $application = Application::find($id);
        
        if (!$application) {
            $this->error('Application not found');
            return 1;
        }

        $this->info('Application #' . $id . ' Data:');
        $this->line('');
        
        $formData = $application->form_data ?? [];
        
        // Show expense categories
        if (isset($formData['expenseCategories'])) {
            $this->info('Expense Categories:');
            foreach ($formData['expenseCategories'] as $category => $expenses) {
                $this->line("  {$category}: " . count($expenses) . ' items');
                foreach ($expenses as $i => $expense) {
                    $this->line("    [{$i}] " . ($expense['name'] ?? 'N/A'));
                }
            }
        }
        
        return 0;
    }
}

