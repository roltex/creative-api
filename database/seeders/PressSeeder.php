<?php

namespace Database\Seeders;

use App\Models\Press;
use App\Models\User;
use Illuminate\Database\Seeder;

class PressSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('📺 Seeding Press releases...');
        
        $admin = User::first();
        
        $pressReleases = [
            [
                'slug' => 'shemoqmedebiti-saqartvelo-2024-wliuri-angarishi',
                'title' => [
                    'ka' => 'შემოქმედებითი საქართველო წარმოადგენს 2024 წლის წლიურ ანგარიშს',
                    'en' => 'Creative Georgia Presents 2024 Annual Report'
                ],
                'content' => [
                    'ka' => '<h2>წლიური ანგარიშის ძირითადი მონაცემები</h2><p>სსიპ შემოქმედებითი საქართველო წარმოადგენს 2024 წლის წლიურ ანგარიშს, რომელშიც წარმოდგენილია ორგანიზაციის საქმიანობის შედეგები.</p><h3>ძირითადი მიღწევები:</h3><ul><li>500+ მხარდაჭერილი პროექტი</li><li>100+ ახალგაზრდა შემოქმედი</li><li>15M+ ლარი დაფინანსება</li></ul><p>ანგარიშში ზედმიწევნით არის აღწერილი ყველა მთავარი პროექტი რომელმაც წარმატებით განვითარება 2024 წელს.</p>',
                    'en' => '<h2>Annual Report Key Data</h2><p>Creative Georgia presents its 2024 annual report detailing the organization\'s activities and results.</p><h3>Key Achievements:</h3><ul><li>500+ supported projects</li><li>100+ young creators</li><li>15M+ GEL funding</li></ul><p>The report comprehensively covers all major projects that successfully developed in 2024.</p>'
                ],
                'excerpt' => [
                    'ka' => '2024 წლის წლიური ანგარიში: 500+ პროექტი, 100+ შემოქმედი და 15M+ ლარი დაფინანსება',
                    'en' => '2024 Annual Report: 500+ projects, 100+ creators and 15M+ GEL funding'
                ],
                'media_name' => 'First Channel',
                'media_link' => 'https://1tv.ge/news/creative-georgia-annual-report-2024',
                'media_logo' => null, // Can be uploaded
                'category' => 'ანგარიშგება',
                'published_at' => '2024-12-20',
                'author_id' => $admin?->id,
                'tags' => ['annual-report', 'achievements', 'funding'],
                'view_count' => 2450,
                'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=800&h=600&fit=crop'
            ],
            [
                'slug' => 'tv-interviu-direqtoris-strategiul-gegmeebze',
                'title' => [
                    'ka' => 'შემოქმედებითი საქართველოს დირექტორი პირველ არხზე სტრატეგიულ გეგმებზე',
                    'en' => 'Creative Georgia Director on First Channel About Strategic Plans'
                ],
                'content' => [
                    'ka' => '<h2>ინტერვიუს ძირითადი თემები</h2><p>შემოქმედებითი საქართველოს გენერალური დირექტორი გამოჩნდა პირველ არხის გადაცემაში, სადაც განიხილა ორგანიზაციის მომავალი გეგმები.</p><h3>განხილული საკითხები:</h3><ul><li>2025-2027 სტრატეგიული გეგმა</li><li>ახალი გრანტების პროგრამები</li><li>საერთაშორისო თანამშრომლობა</li></ul><blockquote>"ჩვენი მიზანია საქართველო გავხადოთ რეგიონის კრეატიული ცენტრი"</blockquote>',
                    'en' => '<h2>Interview Key Topics</h2><p>Creative Georgia\'s General Director appeared on First Channel discussing the organization\'s future plans.</p><h3>Discussed Topics:</h3><ul><li>2025-2027 Strategic Plan</li><li>New Grant Programs</li><li>International Cooperation</li></ul><blockquote>"Our goal is to make Georgia the creative center of the region"</blockquote>'
                ],
                'excerpt' => [
                    'ka' => 'გენერალური დირექტორის ინტერვიუ პირველ არხზე 2025-2027 სტრატეგიული გეგმების და ახალი პროგრამების შესახებ',
                    'en' => 'General Director\'s interview on First Channel about 2025-2027 strategic plans and new programs'
                ],
                'media_name' => '1TV',
                'media_link' => 'https://1tv.ge/show/interview-creative-georgia-director',
                'media_logo' => null,
                'category' => 'ინტერვიუ',
                'published_at' => '2024-12-10',
                'author_id' => $admin?->id,
                'tags' => ['interview', 'tv', 'strategy', 'director'],
                'view_count' => 1890,
                'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1560170407-be019830343a?w=800&h=600&fit=crop'
            ],
            [
                'slug' => 'granteebis-programis-gamotsxadeba',
                'title' => [
                    'ka' => 'მხატვრული პროექტების დაფინანსების ახალი ინიციატივა',
                    'en' => 'New Initiative for Art Project Funding'
                ],
                'content' => [
                    'ka' => '<p>შემოქმედებითი საქართველო აცხადებს ახალ პროგრამას ხელოვნების პროექტების დაფინანსებისთვის.</p><p>პროგრამა მოიცავს:</p><ul><li>ინდივიდუალური მხატვრების მხარდაჭერას</li><li>გუნდური პროექტების დაფინანსებას</li><li>საერთაშორისო თანამშრომლობის ხელშეწყობას</li></ul>',
                    'en' => '<p>Creative Georgia announces new program for funding art projects.</p><p>Program includes:</p><ul><li>Support for individual artists</li><li>Funding for team projects</li><li>Promoting international collaboration</li></ul>'
                ],
                'excerpt' => [
                    'ka' => 'ახალი გრანტების პროგრამა ახალგაზრდა მხატვრებისა და კრეატორებისთვის ინდივიდუალური და გუნდური პროექტების მხარდაჭერით',
                    'en' => 'New grants program for young artists and creators supporting individual and team projects'
                ],
                'media_name' => 'Imedi TV',
                'media_link' => 'https://imedinews.ge/arts/creative-georgia-new-funding-initiative',
                'media_logo' => null,
                'category' => 'გამოცხადება',
                'published_at' => '2024-12-01',
                'author_id' => $admin?->id,
                'tags' => ['funding', 'grants', 'announcement', 'artists'],
                'view_count' => 1780,
                'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=800&h=600&fit=crop'
            ],
            [
                'slug' => 'radio-interviu-kulturuli-memkvidreoba',
                'title' => [
                    'ka' => 'შემოქმედებითი საქართველოს ექსპერტი რადიოზე კულტურული მემკვიდრეობის შესახებ',
                    'en' => 'Creative Georgia Expert on Radio About Cultural Heritage'
                ],
                'content' => [
                    'ka' => '<p>შემოქმედებითი საქართველოს კულტუროლოგი გამოჩნდა რადიო "თავისუფლებაზე" სადაც განიხილა ქართული კულტურული მემკვიდრეობის შენარჩუნების მნიშვნელობა.</p><p>განხილული თემები მოიცავდა ტრადიციული ხელოსნობის, ფოლკლორისა და თანამედროვე ხელოვნების ინტეგრაციას.</p>',
                    'en' => '<p>Creative Georgia cultural expert appeared on Radio "Freedom" discussing the importance of preserving Georgian cultural heritage.</p><p>Topics covered included integration of traditional crafts, folklore and contemporary arts.</p>'
                ],
                'excerpt' => [
                    'ka' => 'კულტუროლოგის რადიო ინტერვიუ კულტურული მემკვიდრეობის შენარჩუნების შესახებ ტრადიციული და თანამედროვე ხელოვნების ინტეგრაციაზე',
                    'en' => 'Cultural expert\'s radio interview about preserving cultural heritage and integrating traditional and contemporary arts'
                ],
                'media_name' => 'Radio Tavisupleba',
                'media_link' => 'https://radiotavisupleba.ge/cultural-heritage-interview',
                'media_logo' => null,
                'category' => 'ინტერვიუ',
                'published_at' => '2024-11-25',
                'author_id' => $admin?->id,
                'tags' => ['radio', 'heritage', 'expert', 'culture'],
                'view_count' => 1200,
                'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&h=600&fit=crop'
            ],
            [
                'slug' => 'gazeti-axalgazrda-programeebis-shesaxeb',
                'title' => [
                    'ka' => 'გაზეთი "რეზონანსი" - ახალგაზრდების პროგრამების შესახებ',
                    'en' => 'Newspaper "Resonance" - About Youth Programs'
                ],
                'content' => [
                    'ka' => '<p>გაზეთი "რეზონანსი" გამოაქვეყნა სტატია შემოქმედებითი საქართველოს ახალგაზრდების პროგრამების შესახებ.</p><h3>სტატიაში განხილულია:</h3><ul><li>მენტორობის პროგრამები</li><li>ვორკშოპები და ტრეინინგები</li><li>წარმატების ისტორიები</li></ul>',
                    'en' => '<p>Newspaper "Resonance" published an article about Creative Georgia\'s youth programs.</p><h3>Article covers:</h3><ul><li>Mentorship programs</li><li>Workshops and trainings</li><li>Success stories</li></ul>'
                ],
                'excerpt' => [
                    'ka' => 'სტატია გაზეთში ახალგაზრდების პროგრამების, მენტორობის და წარმატების ისტორიების შესახებ',
                    'en' => 'Newspaper article about youth programs, mentorship and success stories'
                ],
                'media_name' => 'Rezonansi',
                'media_link' => 'https://rezonansi.ge/youth-programs-creative-georgia',
                'media_logo' => null,
                'category' => 'სტატია',
                'published_at' => '2024-11-15',
                'author_id' => $admin?->id,
                'tags' => ['newspaper', 'youth', 'programs', 'mentorship'],
                'view_count' => 1450,
                'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=800&h=600&fit=crop'
            ]
        ];

        foreach ($pressReleases as $press) {
            Press::create($press);
        }
        
        $this->command->info('✓ Seeded ' . count($pressReleases) . ' press releases');
        $this->command->info('  - Georgian auto-slugs generated');
        $this->command->info('  - Media outlets: First Channel, 1TV, Imedi TV, Radio Tavisupleba, Rezonansi');
        $this->command->info('  - Categories: ანგარიშგება, ინტერვიუ, გამოცხადება, სტატია');
        $this->command->info('  - Rich content with HTML formatting');
    }
}