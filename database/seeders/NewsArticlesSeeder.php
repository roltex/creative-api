<?php

namespace Database\Seeders;

use App\Models\NewsArticle;
use App\Models\User;
use Illuminate\Database\Seeder;

class NewsArticlesSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('📰 Seeding News Articles...');
        
        $admin = User::first();
        
        // Clear existing news articles first
        NewsArticle::truncate();
        
        $articles = [
            [
                'slug' => 'new-creative-grant-program-2024',
                'title' => [
                    'ka' => 'ახალი კრეატიული გრანტების პროგრამა 2024 წელს',
                    'en' => 'New Creative Grants Program for 2024'
                ],
                'content' => [
                    'ka' => '<h2>პროგრამის მიზანი</h2><p>შემოქმედებითი საქართველო აცხადებს ახალ გრანტების პროგრამას, რომელიც მხარს დაუჭერს ახალგაზრდა მხატვრებს და კრეატიულ პროექტებს. პროგრამა მოიცავს სხვადასხვა კატეგორიებს ხელოვნებისა და კრეატიული ინდუსტრიების სფეროში.</p><h3>პროგრამის ძირითადი მიმართულებები:</h3><ul><li>ვიზუალური ხელოვნება</li><li>მუსიკა და ხმოვანი ხელოვნება</li><li>ლიტერატურა და წერა</li><li>თეატრი და სცენური ხელოვნება</li><li>კინო და ვიდეო</li><li>ციფრული ხელოვნება</li></ul><p>განაცხადების მიღება დაიწყება 2024 წლის იანვრიდან და გაგრძელდება მთელი წლის განმავლობაში.</p>',
                    'en' => '<h2>Program Objectives</h2><p>Creative Georgia announces new grants program that will support young artists and creative projects. The program includes various categories in the arts and creative industries.</p><h3>Main program directions:</h3><ul><li>Visual Arts</li><li>Music and Audio Arts</li><li>Literature and Writing</li><li>Theater and Performing Arts</li><li>Film and Video</li><li>Digital Arts</li></ul><p>Applications will be accepted from January 2024 and continue throughout the year.</p>'
                ],
                'excerpt' => [
                    'ka' => 'ახალი გრანტების პროგრამა ახალგაზრდა მხატვრებისა და კრეატიული პროექტებისთვის სხვადასხვა კატეგორიებში',
                    'en' => 'New grants program for young artists and creative projects across various categories'
                ],
                'category' => 'გრანტები',
                'published_at' => '2024-12-15',
                'author_id' => $admin?->id,
                'tags' => ['grants', 'artists', 'creative', 'program'],
                'view_count' => 1850,
                'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=800&h=600&fit=crop',
                'gallery' => [
                    'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1541961017774-22349e4a1262?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800&h=600&fit=crop'
                ]
            ],
            [
                'slug' => 'international-art-festival-tbilisi',
                'title' => [
                    'ka' => 'საერთაშორისო ხელოვნების ფესტივალი თბილისში',
                    'en' => 'International Art Festival in Tbilisi'
                ],
                'content' => [
                    'ka' => '<h2>ფესტივალის დეტალები</h2><p>თბილისში ჩატარდება საერთაშორისო ხელოვნების ფესტივალი, სადაც მონაწილეობას მიიღებენ 50-ზე მეტი ქვეყნის მხატვრები.</p><p>ფესტივალი მოიცავს:</p><ul><li>გამოფენებს</li><li>მასტერკლასებს</li><li>ვორკშოპებს</li><li>კრეატიულ შეხვედრებს</li></ul><blockquote>ეს იქნება უდიდესი ხელოვნების ღონისძიება საქართველოში!</blockquote>',
                    'en' => '<h2>Festival Details</h2><p>An international art festival will be held in Tbilisi, featuring artists from over 50 countries.</p><p>The festival includes:</p><ul><li>Exhibitions</li><li>Masterclasses</li><li>Workshops</li><li>Creative meetings</li></ul><blockquote>This will be the biggest art event in Georgia!</blockquote>'
                ],
                'excerpt' => [
                    'ka' => 'საერთაშორისო ხელოვნების ფესტივალი 50-ზე მეტი ქვეყნის მონაწილეობით მოიცავს გამოფენებს, მასტერკლასებს და ვორკშოპებს',
                    'en' => 'International art festival with participation from over 50 countries includes exhibitions, masterclasses and workshops'
                ],
                'category' => 'ღონისძიებები',
                'published_at' => '2024-12-10',
                'author_id' => $admin?->id,
                'tags' => ['festival', 'international', 'art', 'exhibition'],
                'view_count' => 2350,
                'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop',
                'gallery' => [
                    'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1541961017774-22349e4a1262?w=800&h=600&fit=crop'
                ]
            ],
            [
                'slug' => 'young-filmmaker-competition-results',
                'title' => [
                    'ka' => 'ახალგაზრდა კინემატოგრაფისტების კონკურსის შედეგები',
                    'en' => 'Young Filmmakers Competition Results'
                ],
                'content' => [
                    'ka' => '<h2>კონკურსის გამარჯვებულები</h2><p>შემოქმედებითი საქართველოს მიერ ორგანიზებული ახალგაზრდა კინემატოგრაფისტების კონკურსის გამარჯვებულები გამოვლინდნენ.</p><h3>პირველი ადგილი:</h3><p>ნინო თავართქილაძე - დოკუმენტური ფილმი "ქართული მუსიკის ისტორია"</p><h3>მეორე ადგილი:</h3><p>გიორგი ბერიძე - მოკლემეტრაჟიანი ფილმი "თბილისური ცხოვრება"</p>',
                    'en' => '<h2>Competition Winners</h2><p>Winners of the Young Filmmakers Competition organized by Creative Georgia have been announced.</p><h3>First Place:</h3><p>Nino Tavartkiladze - Documentary "History of Georgian Music"</p><h3>Second Place:</h3><p>Giorgi Beridze - Short Film "Tbilisi Life"</p>'
                ],
                'excerpt' => [
                    'ka' => 'ახალგაზრდა კინემატოგრაფისტების კონკურსის გამარჯვებულები გამოცხადდნენ. პირველი ადგილი დოკუმენტური ფილმისთვის',
                    'en' => 'Young filmmakers competition winners announced. First place for documentary film'
                ],
                'category' => 'კონკურსები',
                'published_at' => '2024-12-05',
                'author_id' => $admin?->id,
                'tags' => ['competition', 'filmmaking', 'youth', 'winners'],
                'view_count' => 1650,
                'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1485846234645-a62644f84728?w=800&h=600&fit=crop',
                'gallery' => []
            ],
            [
                'slug' => 'digital-art-exhibition-opening',
                'title' => [
                    'ka' => 'დიგიტალური ხელოვნების გამოფენის გახსნა',
                    'en' => 'Digital Art Exhibition Opening'
                ],
                'content' => [
                    'ka' => '<p>თბილისში გაიხსნა დიგიტალური ხელოვნების გამოფენა, სადაც წარმოდგენილია ქართველი მხატვრების ინოვაციური ნამუშევრები.</p><p>გამოფენაზე შეგიძლიათ ნახოთ:</p><ul><li>ინტერაქტიული ინსტალაციები</li><li>ციფრული ნახატები</li><li>3D სკულპტურები</li><li>AR/VR ნამუშევრები</li></ul>',
                    'en' => '<p>A digital art exhibition opened in Tbilisi, featuring innovative works by Georgian artists.</p><p>At the exhibition you can see:</p><ul><li>Interactive installations</li><li>Digital paintings</li><li>3D sculptures</li><li>AR/VR artworks</li></ul>'
                ],
                'excerpt' => [
                    'ka' => 'დიგიტალური ხელოვნების გამოფენა ქართველი მხატვრების ინოვაციური ნამუშევრებით, მათ შორის ინტერაქტიული ინსტალაციები',
                    'en' => 'Digital art exhibition featuring innovative works by Georgian artists, including interactive installations'
                ],
                'category' => 'გამოფენები',
                'published_at' => '2024-11-28',
                'author_id' => $admin?->id,
                'tags' => ['digital', 'art', 'exhibition', 'technology'],
                'view_count' => 1420,
                'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1541961017774-22349e4a1262?w=800&h=600&fit=crop',
                'gallery' => [
                    'https://images.unsplash.com/photo-1541961017774-22349e4a1262?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&h=600&fit=crop'
                ]
            ],
            [
                'slug' => 'creative-workshops-for-students',
                'title' => [
                    'ka' => 'კრეატიული ვორკშოპები სტუდენტებისთვის',
                    'en' => 'Creative Workshops for Students'
                ],
                'content' => [
                    'ka' => '<h2>უფასო ვორკშოპები</h2><p>შემოქმედებითი საქართველო იწყებს უფასო კრეატიულ ვორკშოპებს უნივერსიტეტის სტუდენტებისთვის.</p><h3>ვორკშოპების კატეგორიები:</h3><ul><li>ფოტოგრაფია</li><li>ვიდეო მონტაჟი</li><li>გრაფიკული დიზაინი</li><li>კრეატიული წერა</li></ul><p>რეგისტრაცია გახსნილია ყველა სტუდენტისთვის.</p>',
                    'en' => '<h2>Free Workshops</h2><p>Creative Georgia launches free creative workshops for university students.</p><h3>Workshop Categories:</h3><ul><li>Photography</li><li>Video Editing</li><li>Graphic Design</li><li>Creative Writing</li></ul><p>Registration is open for all students.</p>'
                ],
                'excerpt' => [
                    'ka' => 'უფასო კრეატიული ვორკშოპები უნივერსიტეტის სტუდენტებისთვის ფოტოგრაფია, დიზაინი, წერა და ვიდეოს მიმართულებებით',
                    'en' => 'Free creative workshops for university students in photography, design, writing and video directions'
                ],
                'category' => 'განათლება',
                'published_at' => '2024-11-20',
                'author_id' => $admin?->id,
                'tags' => ['workshops', 'students', 'education', 'free'],
                'view_count' => 980,
                'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=800&h=600&fit=crop',
                'gallery' => []
            ],
            [
                'slug' => 'music-production-mentorship-program',
                'title' => [
                    'ka' => 'მუსიკალური პროდუქციის მენტორობის პროგრამა',
                    'en' => 'Music Production Mentorship Program'
                ],
                'content' => [
                    'ka' => '<h2>მენტორობის პროგრამა</h2><p>დაიწყო მუსიკალური პროდუქციის მენტორობის პროგრამა, რომელიც ახალგაზრდა მუსიკოსებს დაეხმარება საკუთარი ნიჭის განვითარებაში.</p><p>პროგრამა მოიცავს:</p><ul><li>ინდივიდუალურ მენტორობას</li><li>სტუდიაში ჩაწერის შესაძლებლობას</li><li>ინდუსტრიის ექსპერტებთან შეხვედრებს</li></ul>',
                    'en' => '<h2>Mentorship Program</h2><p>Music production mentorship program launched to help young musicians develop their talents.</p><p>Program includes:</p><ul><li>Individual mentorship</li><li>Studio recording opportunities</li><li>Meetings with industry experts</li></ul>'
                ],
                'excerpt' => [
                    'ka' => 'მუსიკალური პროდუქციის მენტორობის პროგრამა ახალგაზრდა მუსიკოსებისთვის ინდივიდუალური მენტორობითა და სტუდიის შესაძლებლობებით',
                    'en' => 'Music production mentorship program for young musicians with individual mentoring and studio opportunities'
                ],
                'category' => 'მუსიკა',
                'published_at' => '2024-11-15',
                'author_id' => $admin?->id,
                'tags' => ['music', 'mentorship', 'production', 'youth'],
                'view_count' => 1280,
                'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&h=600&fit=crop',
                'gallery' => []
            ]
        ];

        foreach ($articles as $article) {
            NewsArticle::create($article);
        }
        
        $this->command->info('✓ Seeded ' . count($articles) . ' news articles');
        $this->command->info('  - Rich content with HTML formatting');
        $this->command->info('  - Georgian/English translations');
        $this->command->info('  - Categories, tags, and galleries');
        $this->command->info('  - Featured articles for homepage');
    }
}