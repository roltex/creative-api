<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Competition;
use App\Models\NewsArticle;
use App\Models\Slider;
use App\Models\Setting;
use App\Models\SocialLink;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user first
        $this->createAdminUser();
        
        // Create roles
        $this->createRoles();
        
        // Call the comprehensive seeder with all content
        $this->call([
            ComprehensiveContentSeeder::class,
        ]);
        
        echo "Database seeded successfully!\n";
        echo "Admin Login:\n";
        echo "Email: admin@creative-georgia.ge\n";
        echo "Password: password\n";
    }

    private function createAdminUser()
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@creative-georgia.ge'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        echo "Admin user created!\n";
        return $admin;
    }

    private function createRoles()
    {
        $roles = ['Super Admin', 'Admin', 'Editor', 'Manager'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Assign Super Admin role to first user
        $admin = User::first();
        if ($admin) {
            $admin->assignRole('Super Admin');
        }
    }

    private function createSettings()
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'შემოქმედებითი საქართველო', 'type' => 'string', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Supporting Arts and Creative Industries', 'type' => 'string', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'info@creative-georgia.ge', 'type' => 'string', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+995 32 2 123 456', 'type' => 'string', 'group' => 'contact'],
            ['key' => 'contact_address_ka', 'value' => 'თბილისი, რუსთაველის გამზირი 42', 'type' => 'string', 'group' => 'contact'],
            ['key' => 'contact_address_en', 'value' => '42 Rustaveli Avenue, Tbilisi, Georgia', 'type' => 'string', 'group' => 'contact'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }

    private function createSocialLinks()
    {
        $socials = [
            ['platform' => 'facebook', 'url' => 'https://facebook.com/creativegeorgia', 'order' => 1],
            ['platform' => 'instagram', 'url' => 'https://instagram.com/creativegeorgia', 'order' => 2],
            ['platform' => 'linkedin', 'url' => 'https://linkedin.com/company/creative-georgia', 'order' => 3],
            ['platform' => 'twitter', 'url' => 'https://twitter.com/creativegeorgia', 'order' => 4],
            ['platform' => 'youtube', 'url' => 'https://youtube.com/creativegeorgia', 'order' => 5],
        ];

        foreach ($socials as $social) {
            SocialLink::updateOrCreate(
                ['platform' => $social['platform']],
                $social
            );
        }
    }

    private function createSliders()
    {
        $slides = [
            [
                'title' => ['ka' => 'შენი ნიჭი - ეროვნული ღირებულება', 'en' => 'Your Talent - National Treasure'],
                'subtitle' => ['ka' => 'ჩვენ ვართ ხიდი, რომელიც შემოქმედებით იდეებს სახელმწიფო რესურსებთან აკავშირებს', 'en' => 'We are the bridge that connects creative ideas with state resources'],
                'category' => ['ka' => 'შემოქმედებითი საქართველო', 'en' => 'Creative Georgia'],
                'image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=1200',
                'order' => 1
            ],
            [
                'title' => ['ka' => 'კონკურსები და გრანტები', 'en' => 'Competitions and Grants'],
                'subtitle' => ['ka' => 'იდეიდან განხორციელებამდე - მხარდაჭერა თქვენი პროექტებისთვის', 'en' => 'From idea to implementation - support for your projects'],
                'category' => ['ka' => 'დაფინანსება', 'en' => 'Funding'],
                'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1200',
                'order' => 2
            ],
        ];

        foreach ($slides as $slide) {
            Slider::create($slide);
        }
    }

    private function createCompetitions()
    {
        $competitions = [
            [
                'slug' => 'young-artist-competition-2024',
                'title' => ['ka' => 'ახალგაზრდა მხატვრის კონკურსი 2024', 'en' => 'Young Artist Competition 2024'],
                'description' => ['ka' => 'ახალგაზრდა მხატვრებისა და კრეატიული ადამიანებისთვის განკუთვნილი ყოველწლიური კონკურსი', 'en' => 'Annual competition for young artists and creative individuals'],
                'status' => 'current',
                'start_date' => '2024-09-01',
                'end_date' => '2024-12-31',
                'criteria' => ['ka' => 'ასაკი: 18-35 წელი, ორიგინალური ნამუშევრები', 'en' => 'Age: 18-35 years, Original artworks'],
                'rules' => ['ka' => 'მაქსიმუმ 5 ნამუშევარი, ციფრული ფორმატი', 'en' => 'Maximum 5 artworks, Digital format'],
                'category' => 'Visual Arts',
                'prize' => '₾15,000',
                'max_participants' => 100,
                'current_participants' => 67,
                'image' => 'https://images.unsplash.com/photo-1541961017774-22349e4a1262?w=600',
                'is_featured' => true,
                'order' => 1
            ],
            [
                'slug' => 'digital-innovation-grant',
                'title' => ['ka' => 'ციფრული ინოვაციების გრანტი', 'en' => 'Digital Innovation Grant'],
                'description' => ['ka' => 'ციფრული ხელოვნებისა და ტექნოლოგიების განვითარების მხარდაჭერა', 'en' => 'Supporting digital arts and technology development'],
                'status' => 'current',
                'start_date' => '2024-09-15',
                'end_date' => '2024-11-30',
                'criteria' => ['ka' => 'ტექნოლოგიური პროექტი, ბიზნეს გეგმა', 'en' => 'Technology project, Business plan'],
                'rules' => ['ka' => 'სტარტაპები და ინდივიდუალები', 'en' => 'Startups and individuals'],
                'category' => 'Digital Arts',
                'prize' => '₾25,000',
                'max_participants' => 50,
                'current_participants' => 23,
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600',
                'order' => 2
            ],
        ];

        foreach ($competitions as $competition) {
            Competition::create($competition);
        }
    }

    private function createNewsArticles()
    {
        $articles = [
            [
                'slug' => 'new-creative-grant-program-2024',
                'title' => ['ka' => 'ახალი კრეატიული გრანტების პროგრამა 2024 წელს', 'en' => 'New Creative Grants Program for 2024'],
                'content' => ['ka' => 'შემოქმედებითი საქართველო აცხადებს ახალ გრანტების პროგრამას...', 'en' => 'Creative Georgia announces new grants program...'],
                'excerpt' => ['ka' => 'ახალი გრანტების პროგრამა ახალგაზრდა მხატვრებისთვის', 'en' => 'New grants program for young artists'],
                'image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=400',
                'published_at' => '2024-12-15',
                'category' => 'გრანტები',
                'type' => 'news',
                'view_count' => 1850,
                'is_featured' => true
            ],
            [
                'slug' => 'international-art-festival-tbilisi',
                'title' => ['ka' => 'საერთაშორისო ხელოვნების ფესტივალი თბილისში', 'en' => 'International Art Festival in Tbilisi'],
                'content' => ['ka' => 'თბილისში ჩატარდება საერთაშორისო ხელოვნების ფესტივალი...', 'en' => 'An international art festival will be held in Tbilisi...'],
                'excerpt' => ['ka' => 'საერთაშორისო ხელოვნების ფესტივალი 50-ზე მეტი ქვეყნის მონაწილეობით', 'en' => 'International art festival with participation from over 50 countries'],
                'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400',
                'published_at' => '2024-12-10',
                'category' => 'ღონისძიებები',
                'type' => 'news',
                'view_count' => 2350
            ],
        ];

        foreach ($articles as $article) {
            NewsArticle::create($article);
        }
    }
}
