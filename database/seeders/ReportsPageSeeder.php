<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class ReportsPageSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('📊 Seeding Reports & Strategy page...');
        
        $reportsPage = Page::updateOrCreate(
            ['slug' => 'about/reports'],
            [
                'title' => [
                    'ka' => 'ანგარიშგებები და სტრატეგია',
                    'en' => 'Reports & Strategy'
                ],
                'subtitle' => [
                    'ka' => 'გაეცანით ჩვენს საქმიანობასა და განვითარების გეგმებს',
                    'en' => 'Learn about our activities and development plans'
                ],
                'template' => 'reports',
                'status' => 'published',
                'order' => 2,
                
                // Annual Reports Section
                'annual_reports_title' => [
                    'ka' => 'წლიური ანგარიშები',
                    'en' => 'Annual Reports'
                ],
                'annual_reports_list' => [
                    [
                        'year' => 2024,
                        'title_ka' => '2024 წლის წლიური ანგარიში',
                        'title_en' => '2024 Annual Report',
                        'description_ka' => 'პროექტებისა და მიღწევების მიმოხილვა',
                        'description_en' => 'Overview of projects and achievements',
                        'file' => null, // Can be uploaded via admin
                        'icon' => 'heroicon-o-document-text'
                    ],
                    [
                        'year' => 2023,
                        'title_ka' => '2023 წლის წლიური ანგარიში',
                        'title_en' => '2023 Annual Report',
                        'description_ka' => 'წარსული წლის საქმიანობის მიმოხილვა',
                        'description_en' => 'Overview of previous year\'s activities',
                        'file' => null,
                        'icon' => 'heroicon-o-document-text'
                    ],
                    [
                        'year' => 2022,
                        'title_ka' => '2022 წლის წლიური ანგარიში',
                        'title_en' => '2022 Annual Report',
                        'description_ka' => 'პროექტებისა და დაფინანსების მიმოხილვა',
                        'description_en' => 'Overview of projects and funding',
                        'file' => null,
                        'icon' => 'heroicon-o-document-text'
                    ]
                ],
                
                // Strategic Plans Section
                'strategic_plans_title' => [
                    'ka' => 'სტრატეგიული გეგმები',
                    'en' => 'Strategic Plans'
                ],
                'strategic_plans_list' => [
                    [
                        'period' => '2025-2027',
                        'title_ka' => 'სტრატეგიული გეგმა 2025-2027',
                        'title_en' => 'Strategic Plan 2025-2027',
                        'description_ka' => 'სამწლიანი განვითარების გეგმა კრეატიული ინდუსტრიების მხარდაჭერისათვის',
                        'description_en' => 'Three-year development plan for supporting creative industries',
                        'file' => null,
                        'style' => 'primary'
                    ],
                    [
                        'period' => '2022-2024',
                        'title_ka' => 'სტრატეგიული გეგმა 2022-2024',
                        'title_en' => 'Strategic Plan 2022-2024',
                        'description_ka' => 'წარსული სტრატეგიული პერიოდის გეგმა და მიღწეული შედეგები',
                        'description_en' => 'Past strategic period plan and achieved results',
                        'file' => null,
                        'style' => 'secondary'
                    ]
                ],
                
                // Financial Reports Section
                'financial_reports_title' => [
                    'ka' => 'ფინანსური ანგარიშები',
                    'en' => 'Financial Reports'
                ],
                'financial_reports_list' => [
                    [
                        'year' => 2024,
                        'title_ka' => '2024 წლის ფინანსური ანგარიში',
                        'title_en' => '2024 Financial Report',
                        'description_ka' => 'პროექტების დაფინანსების განაწილება',
                        'description_en' => 'Distribution of project funding',
                        'file' => null
                    ],
                    [
                        'year' => 2023,
                        'title_ka' => '2023 წლის ფინანსური ანგარიში',
                        'title_en' => '2023 Financial Report',
                        'description_ka' => 'წარსული წლის დაფინანსებული პროექტების მიმოხილვა',
                        'description_en' => 'Overview of previous year\'s funded projects',
                        'file' => null
                    ]
                ],
                
                // Key Achievements Section
                'achievements_title' => [
                    'ka' => 'ძირითადი მიღწევები',
                    'en' => 'Key Achievements'
                ],
                'achievements_list' => [
                    [
                        'number' => '1000+',
                        'label_ka' => 'მხარდაჭერილი პროექტი',
                        'label_en' => 'Supported Projects',
                        'icon' => 'heroicon-o-briefcase'
                    ],
                    [
                        'number' => '500+',
                        'label_ka' => 'წარმატებული შემოქმედი',
                        'label_en' => 'Successful Creators',
                        'icon' => 'heroicon-o-users'
                    ],
                    [
                        'number' => '50M+',
                        'label_ka' => 'ლარი დაფინანსება',
                        'label_en' => 'GEL Funding',
                        'icon' => 'heroicon-o-banknotes'
                    ]
                ],
                
                // SEO
                'meta_title' => [
                    'ka' => 'ანგარიშგებები და სტრატეგია - შემოქმედებითი საქართველო',
                    'en' => 'Reports & Strategy - Creative Georgia'
                ],
                'meta_description' => [
                    'ka' => 'გაეცანით შემოქმედებითი საქართველოს წლიურ ანგარიშებს, სტრატეგიულ გეგმებს და ფინანსურ ანგარიშებს.',
                    'en' => 'View Creative Georgia\'s annual reports, strategic plans, and financial reports.'
                ]
            ]
        );
        
        $this->command->info('✓ Reports page created/updated');
        $this->command->info("Reports page accessible at: /pages/{$reportsPage->slug}");
        $this->command->info('📊 Reports template includes:');
        $this->command->info('  - ' . count($reportsPage->annual_reports_list) . ' Annual Reports');
        $this->command->info('  - ' . count($reportsPage->strategic_plans_list) . ' Strategic Plans');
        $this->command->info('  - ' . count($reportsPage->financial_reports_list) . ' Financial Reports');
        $this->command->info('  - ' . count($reportsPage->achievements_list) . ' Key Achievements');
    }
}