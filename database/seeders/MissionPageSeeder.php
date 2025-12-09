<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class MissionPageSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🎯 Seeding Mission page...');
        
        $missionPage = Page::updateOrCreate(
            ['slug' => 'about/mission'],
            [
                'title' => [
                    'ka' => 'მისია და მიზნები',
                    'en' => 'Mission & Goals'
                ],
                'subtitle' => [
                    'ka' => 'შემოქმედებითი საქართველო - ხელოვნებისა და კრეატიული ინდუსტრიების მხარდაჭერის ორგანიზაცია',
                    'en' => 'Creative Georgia - Supporting Arts and Creative Industries Organization'
                ],
                'template' => 'mission',
                'status' => 'published',
                'order' => 1,
                
                // Hero Section
                'hero_subtitle' => [
                    'ka' => 'გაეცანით ჩვენს ხედვასა და მისიას',
                    'en' => 'Learn about our vision and mission'
                ],
                
                // Mission Section
                'mission_title' => [
                    'ka' => 'ჩვენი მისია',
                    'en' => 'Our Mission'
                ],
                'mission_content' => [
                    'ka' => 'შემოქმედებითი საქართველოს მისიაა მხარდაჭერა გაუწიოს ქართულ ხელოვნებასა და კრეატიულ ინდუსტრიებს, ხელი შეუწყოს ახალგაზრდა ხელოვანების განვითარებას და ხელი შეუწყოს კრეატიული პროექტების რეალიზაციას კონკურსებისა და გრანტების მეშვეობით.',
                    'en' => 'Creative Georgia\'s mission is to support Georgian arts and creative industries, promote the development of young artists, and facilitate the realization of creative projects through competitions and grants.'
                ],
                'mission_content_2' => [
                    'ka' => 'ჩვენ ვართ მხარდამჭერი ყველა შემოქმედისთვის, რომელსაც აქვს ხედვა და ენთუზიაზმი საქართველოს კულტურული მემკვიდრეობის განვითარებისა და გადაცემისთვის.',
                    'en' => 'We are supporters of all creators who have the vision and enthusiasm for the development and transmission of Georgia\'s cultural heritage.'
                ],
                
                // Goals Section
                'goals_title' => [
                    'ka' => 'ჩვენი მიზნები',
                    'en' => 'Our Goals'
                ],
                'goals_content' => [
                    'ka' => 'ჩვენი მიზანია საქართველო გავხდეთ კრეატიული ხელოვნების რეგიონალური ცენტრი, სადაც ყველა ნიჭიერმა შემოქმედმა შეძლებს თავიანთი პროექტის რეალიზაციას და საერთაშორისო წარმატების მიღწევას ჩვენი მხარდაჭერით და რესურსებით.',
                    'en' => 'Our goal is to make Georgia a regional center for creative arts where every talented creator can realize their projects and achieve international success with our support and resources.'
                ],
                'goals_list' => [
                    [
                        'ka' => 'ხელოვანებისა და კრეატორების მხარდაჭერა ფინანსური და პროფესიონალური რესურსების მეშვეობით',
                        'en' => 'Supporting artists and creators through financial and professional resources'
                    ],
                    [
                        'ka' => 'კრეატიული პროექტების რეალიზაციაში დახმარება და გრძელვადიანი მხარდაჭერა',
                        'en' => 'Helping and long-term support in realizing creative projects'
                    ],
                    [
                        'ka' => 'ქართული ხელოვნების პოპულარიზაცია როგორც საქართველოში, ასევე საერთაშორისო მასშტაბით',
                        'en' => 'Promoting Georgian arts both in Georgia and internationally'
                    ],
                    [
                        'ka' => 'კრეატიული ინდუსტრიების განვითარება და პროფესიონალიზმის წახალისება',
                        'en' => 'Developing creative industries and encouraging professionalism'
                    ]
                ],
                
                // Values Section
                'values_title' => [
                    'ka' => 'ჩვენი ღირებულებები',
                    'en' => 'Our Values'
                ],
                'values_list' => [
                    [
                        'title_ka' => 'კრეატიულობა',
                        'title_en' => 'Creativity',
                        'description_ka' => 'ჩვენ ვუჭერთ მხარს გამოუყნებელ იდეებსა და ინოვაციურ მიდგომებს',
                        'description_en' => 'We support unique ideas and innovative approaches',
                        'icon' => 'heroicon-o-light-bulb'
                    ],
                    [
                        'title_ka' => 'სამართლიანობა',
                        'title_en' => 'Fairness',
                        'description_ka' => 'ყველა ნიჭიერ შემოქმედს ვაძლევთ თანაბარ შესაძლებლობებს',
                        'description_en' => 'We provide equal opportunities to all talented creators',
                        'icon' => 'heroicon-o-balance-scales'
                    ],
                    [
                        'title_ka' => 'წარმატება',
                        'title_en' => 'Success',
                        'description_ka' => 'ჩვენი მხარდაჭერით ხელოვანები აღწევენ უმაღლეს შედეგებს',
                        'description_en' => 'With our support, artists achieve the highest results',
                        'icon' => 'heroicon-o-trophy'
                    ]
                ],
                
                // Stats Section
                'stats_title' => [
                    'ka' => 'ჩვენი მიღწევები',
                    'en' => 'Our Achievements'
                ],
                'stats_list' => [
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
                        'icon' => 'heroicon-o-currency-dollar'
                    ]
                ],
                
                // SEO
                'meta_title' => [
                    'ka' => 'მისია და მიზნები - შემოქმედებითი საქართველო',
                    'en' => 'Mission & Goals - Creative Georgia'
                ],
                'meta_description' => [
                    'ka' => 'გაეცანით შემოქმედებითი საქართველოს მისიას, მიზნებს და ღირებულებებს. ჩვენი ხედვა ქართული ხელოვნებისა და კრეატიული ინდუსტრიების მხარდაჭერის შესახებ.',
                    'en' => 'Learn about Creative Georgia\'s mission, goals and values. Our vision for supporting Georgian arts and creative industries.'
                ]
            ]
        );
        
        $this->command->info('✓ Mission page created/updated');
        $this->command->info("Mission page accessible at: /pages/{$missionPage->slug}");
    }
}