<?php

namespace Database\Seeders;

use App\Models\Press;
use Illuminate\Database\Seeder;

class SimplePressSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('📺 Seeding Simple Press releases (4 fields only)...');
        
        $pressReleases = [
            [
                'press_title' => [
                    'ka' => 'შემოქმედებითი საქართველო წარმოადგენს 2024 წლის წლიურ ანგარიშს',
                    'en' => 'Creative Georgia Presents 2024 Annual Report'
                ],
                'media_name' => [
                    'ka' => 'პირველი არხი',
                    'en' => 'First Channel'
                ],
                'media_link' => 'https://1tv.ge/news/creative-georgia-annual-report-2024',
                'media_logo' => null, // Can be uploaded later
            ],
            [
                'press_title' => [
                    'ka' => 'დირექტორის ინტერვიუ სტრატეგიული გეგმების შესახებ',
                    'en' => 'Director\'s Interview About Strategic Plans'
                ],
                'media_name' => [
                    'ka' => '1TV',
                    'en' => '1TV'
                ],
                'media_link' => 'https://1tv.ge/show/interview-creative-georgia-director',
                'media_logo' => null,
            ],
            [
                'press_title' => [
                    'ka' => 'ახალი გრანტების პროგრამის გამოცხადება',
                    'en' => 'New Grant Program Announcement'
                ],
                'media_name' => [
                    'ka' => 'იმედი',
                    'en' => 'Imedi TV'
                ],
                'media_link' => 'https://imedinews.ge/arts/creative-georgia-new-funding',
                'media_logo' => null,
            ],
            [
                'press_title' => [
                    'ka' => 'კულტურული მემკვიდრეობის შესახებ რადიო ინტერვიუ',
                    'en' => 'Radio Interview About Cultural Heritage'
                ],
                'media_name' => [
                    'ka' => 'რადიო თავისუფლება',
                    'en' => 'Radio Tavisupleba'
                ],
                'media_link' => 'https://radiotavisupleba.ge/cultural-heritage-interview',
                'media_logo' => null,
            ],
            [
                'press_title' => [
                    'ka' => 'ახალგაზრდების პროგრამების შესახებ სტატია',
                    'en' => 'Article About Youth Programs'
                ],
                'media_name' => [
                    'ka' => 'რეზონანსი',
                    'en' => 'Rezonansi'
                ],
                'media_link' => 'https://rezonansi.ge/youth-programs-creative-georgia',
                'media_logo' => null,
            ],
        ];

        foreach ($pressReleases as $press) {
            Press::create($press);
        }
        
        $this->command->info('✓ Seeded ' . count($pressReleases) . ' simple press releases');
        $this->command->info('  - Only 4 fields: Title, Media Name, Link, Logo');
        $this->command->info('  - Georgian/English titles and media names');
        $this->command->info('  - Various media outlets');
    }
}
