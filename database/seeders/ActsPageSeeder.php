<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class ActsPageSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('⚖️ Seeding Acts & Regulations page...');
        
        $actsPage = Page::updateOrCreate(
            ['slug' => 'resources/acts'],
            [
                'title' => [
                    'ka' => 'აქტები და დებულებები',
                    'en' => 'Acts & Regulations'
                ],
                'subtitle' => [
                    'ka' => 'სამართლებრივი დოკუმენტები და ნორმატიული აქტები',
                    'en' => 'Legal documents and regulatory acts'
                ],
                'template' => 'acts',
                'status' => 'published',
                'order' => 3,
                
                // Legal Acts Section
                'legal_acts_title' => [
                    'ka' => 'სამართლებრივი აქტები',
                    'en' => 'Legal Acts'
                ],
                'legal_acts_list' => [
                    [
                        'title_ka' => 'შემოქმედებითი საქართველოს აქტი',
                        'title_en' => 'Creative Georgia Act',
                        'description_ka' => 'ორგანიზაციის დაარსებისა და საქმიანობის რეგულაციის მთავარი სამართლებრივი დოკუმენტი',
                        'description_en' => 'Main legal document regulating the organization\'s establishment and activities',
                        'file' => null,
                        'style' => 'primary',
                        'icon' => 'heroicon-o-scale'
                    ],
                    [
                        'title_ka' => 'შიდა დებულებები',
                        'title_en' => 'Internal Regulations',
                        'description_ka' => 'კონკურსებისა და გრანტების გაცემის პროცედურების რეგულაცია',
                        'description_en' => 'Regulation of procedures for competitions and grants',
                        'file' => null,
                        'style' => 'secondary',
                        'icon' => 'heroicon-o-cog-6-tooth'
                    ]
                ],
                
                // Regulations Section
                'regulations_title' => [
                    'ka' => 'დებულებები',
                    'en' => 'Regulations'
                ],
                'regulations_list' => [
                    [
                        'title_ka' => 'დაფინანსების წესები',
                        'title_en' => 'Funding Rules',
                        'description_ka' => 'პროექტების დაფინანსების კრიტერიუმები და პროცედურები',
                        'description_en' => 'Criteria and procedures for project funding',
                        'file' => null,
                        'style' => 'primary',
                        'icon' => 'heroicon-o-banknotes'
                    ],
                    [
                        'title_ka' => 'შეფასების კრიტერიუმები',
                        'title_en' => 'Evaluation Criteria',
                        'description_ka' => 'პროექტების შეფასებისა და შერჩევის პროცედურები',
                        'description_en' => 'Procedures for project evaluation and selection',
                        'file' => null,
                        'style' => 'secondary',
                        'icon' => 'heroicon-o-clipboard-document-check'
                    ],
                    [
                        'title_ka' => 'განაცხადის პროცედურა',
                        'title_en' => 'Application Procedure',
                        'description_ka' => 'განაცხადის წარდგენისა და განხილვის პროცედურის დეტალური აღწერა',
                        'description_en' => 'Detailed description of application submission and review procedures',
                        'file' => null,
                        'style' => 'primary',
                        'icon' => 'heroicon-o-document-text'
                    ],
                    [
                        'title_ka' => 'საიდეალო პროცედურა',
                        'title_en' => 'Ideation Procedure',
                        'description_ka' => 'პროექტების იდეალიზაციისა და კონსულტაციის პროცედურა',
                        'description_en' => 'Procedure for project ideation and consultation',
                        'file' => null,
                        'style' => 'secondary',
                        'icon' => 'heroicon-o-light-bulb'
                    ]
                ],
                
                // Additional Information Section
                'additional_info_title' => [
                    'ka' => 'დამატებითი ინფორმაცია',
                    'en' => 'Additional Information'
                ],
                'additional_info_content' => [
                    'ka' => 'თუ გჭირდებათ დახმარება სამართლებრივ დოკუმენტებთან მუშაობაში, დაგვიკავშირდით',
                    'en' => 'If you need help working with legal documents, contact us'
                ],
                'additional_info_button_text' => [
                    'ka' => 'კონტაქტი',
                    'en' => 'Contact'
                ],
                'additional_info_button_url' => '/contact',
                
                // SEO
                'meta_title' => [
                    'ka' => 'აქტები და დებულებები - შემოქმედებითი საქართველო',
                    'en' => 'Acts & Regulations - Creative Georgia'
                ],
                'meta_description' => [
                    'ka' => 'გაეცანით შემოქმედებითი საქართველოს სამართლებრივ აქტებს, დებულებებს და რეგულაციებს.',
                    'en' => 'View Creative Georgia\'s legal acts, regulations and procedures.'
                ]
            ]
        );
        
        $this->command->info('✓ Acts page created/updated');
        $this->command->info("Acts page accessible at: /pages/{$actsPage->slug}");
        $this->command->info('⚖️ Acts template includes:');
        $this->command->info('  - ' . count($actsPage->legal_acts_list) . ' Legal Acts');
        $this->command->info('  - ' . count($actsPage->regulations_list) . ' Regulations');
        $this->command->info('  - Additional Information section');
    }
}