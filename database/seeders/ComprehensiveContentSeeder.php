<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Competition;
use App\Models\NewsArticle;
use App\Models\Event;
use App\Models\SuccessStory;
use App\Models\Slider;
use App\Models\Faq;
use App\Models\Partner;
use App\Models\Setting;
use App\Models\SocialLink;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\User;

class ComprehensiveContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Starting comprehensive content seeding...');
        
        $this->seedCompetitions();
        $this->seedNewsArticles();
        $this->seedPressArticles();
        $this->seedEvents();
        $this->seedSuccessStories();
        $this->seedFAQs();
        $this->seedPartners();
        $this->seedHeroSliders();
        $this->seedMenus();
        $this->seedSettings();
        
        $this->command->info('✅ All content seeded successfully!');
    }

    private function seedCompetitions()
    {
        $this->command->info('📊 Seeding competitions...');
        
        $competitions = [
            // Current Competitions (12)
            [
                'slug' => 'young-artist-competition-2024',
                'title' => ['ka' => 'ახალგაზრდა მხატვრის კონკურსი 2024', 'en' => 'Young Artist Competition 2024'],
                'description' => [
                    'ka' => 'ახალგაზრდა მხატვრებისა და კრეატიული ადამიანებისთვის განკუთვნილი ყოველწლიური კონკურსი. მონაწილეობა შეუძლიათ 18-35 წლის მხატვრებს.',
                    'en' => 'Annual competition for young artists and creative individuals. Open to artists aged 18-35 years.'
                ],
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
                'description' => [
                    'ka' => 'ციფრული ხელოვნებისა და ტექნოლოგიების განვითარების მხარდაჭერა. ინოვაციური პროექტების დაფინანსება და მენტორინგი.',
                    'en' => 'Supporting digital arts and technology development. Funding and mentoring for innovative projects.'
                ],
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
            [
                'slug' => 'cultural-heritage-project',
                'title' => ['ka' => 'კულტურული მემკვიდრეობის პროექტი', 'en' => 'Cultural Heritage Project'],
                'description' => [
                    'ka' => 'ქართული კულტურული მემკვიდრეობის შენარჩუნება, პოპულარიზაცია და თანამედროვე ინტერპრეტაცია. დოკუმენტური და მხატვრული პროექტები.',
                    'en' => 'Preserving, promoting and contemporary interpretation of Georgian cultural heritage. Documentary and artistic projects.'
                ],
                'status' => 'current',
                'start_date' => '2024-08-01',
                'end_date' => '2024-12-15',
                'criteria' => ['ka' => 'კულტურული თემატიკა, კვლევითი კომპონენტი', 'en' => 'Cultural theme, Research component'],
                'rules' => ['ka' => 'ინდივიდუალური და ჯგუფური პროექტები', 'en' => 'Individual and group projects'],
                'category' => 'Cultural Heritage',
                'prize' => '₾20,000',
                'max_participants' => 30,
                'current_participants' => 18,
                'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=600',
                'order' => 3
            ],
            [
                'slug' => 'music-composition-contest',
                'title' => ['ka' => 'მუსიკალური კომპოზიციის კონკურსი', 'en' => 'Music Composition Contest'],
                'description' => [
                    'ka' => 'თანამედროვე ქართული მუსიკის განვითარების ხელშეწყობა. ორიგინალური კომპოზიციების კონკურსი ყველა ჟანრში.',
                    'en' => 'Promoting contemporary Georgian music development. Original compositions contest in all genres.'
                ],
                'status' => 'current',
                'start_date' => '2024-09-10',
                'end_date' => '2024-11-20',
                'criteria' => ['ka' => 'ორიგინალური კომპოზიცია, 3-8 წუთი', 'en' => 'Original composition, 3-8 minutes'],
                'rules' => ['ka' => 'ყველა ჟანრი მისაღებია', 'en' => 'All genres accepted'],
                'category' => 'Music',
                'prize' => '₾18,000',
                'max_participants' => 75,
                'current_participants' => 34,
                'image' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=600',
                'order' => 4
            ],
            [
                'slug' => 'documentary-film-grant',
                'title' => ['ka' => 'დოკუმენტური ფილმის გრანტი', 'en' => 'Documentary Film Grant'],
                'description' => [
                    'ka' => 'საქართველოს სოციალური, კულტურული და ისტორიული თემებზე დოკუმენტური ფილმების შექმნის მხარდაჭერა.',
                    'en' => 'Supporting creation of documentary films on Georgian social, cultural and historical themes.'
                ],
                'status' => 'current',
                'start_date' => '2024-08-15',
                'end_date' => '2024-10-30',
                'criteria' => ['ka' => 'სცენარი, რეჟისორული კონცეფცია', 'en' => 'Script, Director\'s concept'],
                'rules' => ['ka' => 'მინიმუმ 30 წუთი, მაქსიმუმ 90 წუთი', 'en' => 'Minimum 30 min, Maximum 90 min'],
                'category' => 'Film',
                'prize' => '₾30,000',
                'max_participants' => 25,
                'current_participants' => 12,
                'image' => 'https://images.unsplash.com/photo-1485846234645-a62644f84728?w=600',
                'order' => 5
            ],
            [
                'slug' => 'theater-performance-competition',
                'title' => ['ka' => 'თეატრალური სპექტაკლის კონკურსი', 'en' => 'Theater Performance Competition'],
                'description' => [
                    'ka' => 'ახალი თეატრალური სპექტაკლების შექმნა და წარდგენა. ექსპერიმენტული და ტრადიციული მიდგომები.',
                    'en' => 'Creating and presenting new theatrical performances. Experimental and traditional approaches.'
                ],
                'status' => 'current',
                'start_date' => '2024-09-05',
                'end_date' => '2024-12-10',
                'criteria' => ['ka' => 'ორიგინალური სცენარი, რეჟისორული ხედვა', 'en' => 'Original script, Director\'s vision'],
                'rules' => ['ka' => 'სპექტაკლის ხანგრძლივობა: 45-120 წუთი', 'en' => 'Performance duration: 45-120 minutes'],
                'category' => 'Theater',
                'prize' => '₾22,000',
                'max_participants' => 20,
                'current_participants' => 8,
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600',
                'order' => 6
            ],
            [
                'slug' => 'photography-exhibition-grant',
                'title' => ['ka' => 'ფოტოგრაფიის გამოფენის გრანტი', 'en' => 'Photography Exhibition Grant'],
                'description' => [
                    'ka' => 'თანამედროვე ქართული ფოტოგრაფიის განვითარება და პროფესიონალი ფოტოგრაფების მხარდაჭერა.',
                    'en' => 'Developing contemporary Georgian photography and supporting professional photographers.'
                ],
                'status' => 'current',
                'start_date' => '2024-09-01',
                'end_date' => '2024-11-15',
                'criteria' => ['ka' => 'პორტფოლიო 15-25 ფოტო', 'en' => 'Portfolio 15-25 photos'],
                'rules' => ['ka' => 'ყველა ჟანრი, ორიგინალური ნამუშევრები', 'en' => 'All genres, Original works'],
                'category' => 'Photography',
                'prize' => '₾12,000',
                'max_participants' => 60,
                'current_participants' => 41,
                'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=600',
                'order' => 7
            ],
            [
                'slug' => 'creative-writing-contest',
                'title' => ['ka' => 'კრეატიული წერის კონკურსი', 'en' => 'Creative Writing Contest'],
                'description' => [
                    'ka' => 'ახალი ლიტერატურული ხმების აღმოჩენა და მხარდაჭერა. პროზა, პოეზია და დრამატურგია.',
                    'en' => 'Discovering and supporting new literary voices. Prose, poetry and dramaturgy.'
                ],
                'status' => 'current',
                'start_date' => '2024-08-20',
                'end_date' => '2024-12-05',
                'criteria' => ['ka' => 'ორიგინალური ტექსტი ქართულ ენაზე', 'en' => 'Original text in Georgian language'],
                'rules' => ['ka' => 'მაქსიმუმ 5000 სიტყვა', 'en' => 'Maximum 5000 words'],
                'category' => 'Literature',
                'prize' => '₾10,000',
                'max_participants' => 150,
                'current_participants' => 89,
                'image' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?w=600',
                'order' => 8
            ],
            [
                'slug' => 'fashion-design-showcase',
                'title' => ['ka' => 'მოდის დიზაინის ვიტრინა', 'en' => 'Fashion Design Showcase'],
                'description' => [
                    'ka' => 'თანამედროვე ქართული მოდის განვითარება და ახალი დიზაინერების მხარდაჭერა. ეკოლოგიური და მდგრადი მოდის პროექტების წახალისება.',
                    'en' => 'Developing contemporary Georgian fashion and supporting new designers. Encouraging ecological and sustainable fashion projects.'
                ],
                'status' => 'current',
                'start_date' => '2024-09-01',
                'end_date' => '2024-11-25',
                'criteria' => ['ka' => 'კოლექციის პრეზენტაცია, მდგრადობის კომპონენტი', 'en' => 'Collection presentation, Sustainability component'],
                'rules' => ['ka' => 'მინიმუმ 8 ნაწარმოები', 'en' => 'Minimum 8 pieces'],
                'category' => 'Fashion Design',
                'prize' => '₾16,000',
                'max_participants' => 40,
                'current_participants' => 19,
                'image' => 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=600',
                'order' => 9
            ],
            [
                'slug' => 'animation-short-film-contest',
                'title' => ['ka' => 'ანიმაციური მოკლემეტრაჟის კონკურსი', 'en' => 'Animation Short Film Contest'],
                'description' => [
                    'ka' => 'ანიმაციური ხელოვნების განვითარება საქართველოში. ყველა ტიპის ანიმაციური ტექნიკის მხარდაჭერა - ტრადიციული, ციფრული, სტოპ-მოუშენი.',
                    'en' => 'Developing animation art in Georgia. Supporting all types of animation techniques - traditional, digital, stop-motion.'
                ],
                'status' => 'current',
                'start_date' => '2024-08-28',
                'end_date' => '2024-12-20',
                'criteria' => ['ka' => 'ანიმაციური ფილმი 2-10 წუთი', 'en' => 'Animated film 2-10 minutes'],
                'rules' => ['ka' => 'ყველა ანიმაციური ტექნიკა მისაღებია', 'en' => 'All animation techniques accepted'],
                'category' => 'Animation',
                'prize' => '₾14,000',
                'max_participants' => 35,
                'current_participants' => 16,
                'image' => 'https://images.unsplash.com/photo-1606918801925-e2c914c4b503?w=600',
                'order' => 10
            ],
            [
                'slug' => 'culinary-arts-innovation',
                'title' => ['ka' => 'კულინარული ხელოვნების ინოვაცია', 'en' => 'Culinary Arts Innovation'],
                'description' => [
                    'ka' => 'ქართული კულინარული ტრადიციების თანამედროვე ინტერპრეტაცია. ახალი კერძების შექმნა ტრადიციული ინგრედიენტების გამოყენებით.',
                    'en' => 'Contemporary interpretation of Georgian culinary traditions. Creating new dishes using traditional ingredients.'
                ],
                'status' => 'current',
                'start_date' => '2024-09-12',
                'end_date' => '2024-11-30',
                'criteria' => ['ka' => 'რეცეპტი და პრეზენტაცია', 'en' => 'Recipe and presentation'],
                'rules' => ['ka' => 'ქართული ინგრედიენტების გამოყენება', 'en' => 'Use of Georgian ingredients'],
                'category' => 'Culinary Arts',
                'prize' => '₾13,000',
                'max_participants' => 50,
                'current_participants' => 28,
                'image' => 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600',
                'order' => 11
            ],
            [
                'slug' => 'architectural-design-competition',
                'title' => ['ka' => 'არქიტექტურული დიზაინის კონკურსი', 'en' => 'Architectural Design Competition'],
                'description' => [
                    'ka' => 'მდგრადი არქიტექტურის და ურბანული დაგეგმარების განვითარება. ეკოლოგიური და ენერგოეფექტური შენობების პროექტირება.',
                    'en' => 'Developing sustainable architecture and urban planning. Designing ecological and energy-efficient buildings.'
                ],
                'status' => 'current',
                'start_date' => '2024-08-30',
                'end_date' => '2024-12-15',
                'criteria' => ['ka' => 'კონცეპტუალური დიზაინი, მდგრადობა', 'en' => 'Conceptual design, Sustainability'],
                'rules' => ['ka' => 'ციფრული მოდელი და ვიზუალიზაცია', 'en' => 'Digital model and visualization'],
                'category' => 'Architecture',
                'prize' => '₾28,000',
                'max_participants' => 25,
                'current_participants' => 11,
                'image' => 'https://images.unsplash.com/photo-1487958449943-2429e8be8625?w=600',
                'order' => 12
            ],
            
            // Completed Competitions (6)
            [
                'slug' => '2023-film-festival-grant',
                'title' => ['ka' => '2023 კინოფესტივალის გრანტი', 'en' => '2023 Film Festival Grant'],
                'description' => [
                    'ka' => 'წარმატებით დასრულებული კონკურსი საქართველოს ნიჭიერი კინემატოგრაფისტებისთვის. მხარდაჭერილი იქნა 15 დოკუმენტური ფილმის პროექტი.',
                    'en' => 'Successfully completed competition for talented Georgian cinematographers. Supported 15 documentary film projects.'
                ],
                'status' => 'completed',
                'start_date' => '2023-01-15',
                'end_date' => '2023-06-30',
                'criteria' => ['ka' => 'დოკუმენტური ფილმი საქართველოს თემატიკაზე', 'en' => 'Documentary film on Georgian themes'],
                'rules' => ['ka' => 'მინიმუმ 30 წუთი', 'en' => 'Minimum 30 minutes'],
                'category' => 'Film',
                'prize' => '₾50,000',
                'max_participants' => 30,
                'current_participants' => 30,
                'image' => 'https://images.unsplash.com/photo-1485846234645-a62644f84728?w=600',
                'order' => 13
            ],
            [
                'slug' => 'traditional-arts-preservation-2023',
                'title' => ['ka' => 'ტრადიციული ხელოვნების შენარჩუნების პროექტი 2023', 'en' => 'Traditional Arts Preservation Project 2023'],
                'description' => [
                    'ka' => 'წარმატებული პროექტი ქართული ტრადიციული ხელოვნების შენარჩუნებისთვის. მხარდაჭერილი იქნა 20 მოსწავლე და ოსტატი.',
                    'en' => 'Successful project for preserving Georgian traditional arts. Supported 20 apprentices and masters.'
                ],
                'status' => 'completed',
                'start_date' => '2023-03-01',
                'end_date' => '2023-09-30',
                'criteria' => ['ka' => 'ტრადიციული ხელოვნების დარგი', 'en' => 'Traditional art discipline'],
                'rules' => ['ka' => 'ორიგინალური ნამუშევრები', 'en' => 'Original works'],
                'category' => 'Traditional Arts',
                'prize' => '₾35,000',
                'max_participants' => 25,
                'current_participants' => 20,
                'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=600',
                'order' => 14
            ],
            [
                'slug' => 'young-artist-showcase-2023',
                'title' => ['ka' => 'ახალგაზრდა მხატვრების ვიტრინა 2023', 'en' => 'Young Artists Showcase 2023'],
                'description' => [
                    'ka' => 'წარმატებული გამოფენა ახალგაზრდა ქართველ მხატვრების ნამუშევრებით. მონაწილეობდა 45 მხატვარი.',
                    'en' => 'Successful exhibition of works by young Georgian artists. 45 artists participated.'
                ],
                'status' => 'completed',
                'start_date' => '2023-04-01',
                'end_date' => '2023-08-31',
                'criteria' => ['ka' => 'ასაკი: 18-30 წელი', 'en' => 'Age: 18-30 years'],
                'rules' => ['ka' => 'მინიმუმ 3 ნამუშევარი', 'en' => 'Minimum 3 works'],
                'category' => 'Visual Arts',
                'prize' => '₾40,000',
                'max_participants' => 50,
                'current_participants' => 45,
                'image' => 'https://images.unsplash.com/photo-1541961017774-22349e4a1262?w=600',
                'order' => 15
            ],
            [
                'slug' => 'music-production-grant-2023',
                'title' => ['ka' => 'მუსიკალური პროდუქციის გრანტი 2023', 'en' => 'Music Production Grant 2023'],
                'description' => [
                    'ka' => 'დასრულებული პროექტი მუსიკალური პროდუქციის განვითარებისთვის. მხარდაჭერილი იქნა 12 ალბომის პროექტი.',
                    'en' => 'Completed project for music production development. Supported 12 album projects.'
                ],
                'status' => 'completed',
                'start_date' => '2023-01-20',
                'end_date' => '2023-07-15',
                'criteria' => ['ka' => 'ორიგინალური მუსიკალური კომპოზიცია', 'en' => 'Original musical composition'],
                'rules' => ['ka' => 'მინიმუმ 6 სიმღერა', 'en' => 'Minimum 6 songs'],
                'category' => 'Music',
                'prize' => '₾60,000',
                'max_participants' => 20,
                'current_participants' => 12,
                'image' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=600',
                'order' => 16
            ],
            [
                'slug' => 'digital-art-festival-2023',
                'title' => ['ka' => 'ციფრული ხელოვნების ფესტივალი 2023', 'en' => 'Digital Art Festival 2023'],
                'description' => [
                    'ka' => 'წარმატებული ფესტივალი ციფრული ხელოვნების სახეებით. მონაწილეობა მიიღო 30 ხელოვანმა.',
                    'en' => 'Successful festival showcasing digital art forms. 30 artists participated.'
                ],
                'status' => 'completed',
                'start_date' => '2023-02-01',
                'end_date' => '2023-05-31',
                'criteria' => ['ka' => 'ციფრული ხელოვნების ნამუშევარი', 'en' => 'Digital artwork'],
                'rules' => ['ka' => 'ინტერაქტიული ან სტატიკური ნამუშევრები', 'en' => 'Interactive or static works'],
                'category' => 'Digital Arts',
                'prize' => '₾45,000',
                'max_participants' => 35,
                'current_participants' => 30,
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600',
                'order' => 17
            ],
            [
                'slug' => 'photography-exhibition-2023',
                'title' => ['ka' => 'ფოტოგრაფიის გამოფენა 2023', 'en' => 'Photography Exhibition 2023'],
                'description' => [
                    'ka' => 'დასრულებული კონკურსი პროფესიონალ ფოტოგრაფთათვის. საუკეთესო ნამუშევრები გამოფენილი იქნა გალერეაში.',
                    'en' => 'Completed competition for professional photographers. Best works were exhibited in gallery.'
                ],
                'status' => 'completed',
                'start_date' => '2023-05-01',
                'end_date' => '2023-09-30',
                'criteria' => ['ka' => 'ფოტოგრაფიული სერია', 'en' => 'Photography series'],
                'rules' => ['ka' => 'პორტფოლიო 10-20 ფოტო', 'en' => 'Portfolio 10-20 photos'],
                'category' => 'Photography',
                'prize' => '₾25,000',
                'max_participants' => 40,
                'current_participants' => 32,
                'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=600',
                'order' => 18
            ],
        ];

        foreach ($competitions as $competition) {
            Competition::create($competition);
        }
        
        $this->command->info('✓ Seeded ' . count($competitions) . ' competitions');
    }

    private function seedNewsArticles()
    {
        $this->command->info('📰 Seeding news articles...');
        
        $admin = User::first();
        
        $articles = [
            [
                'slug' => 'new-creative-grant-program-2024',
                'title' => ['ka' => 'ახალი კრეატიული გრანტების პროგრამა 2024 წელს', 'en' => 'New Creative Grants Program for 2024'],
                'content' => [
                    'ka' => 'შემოქმედებითი საქართველო აცხადებს ახალ გრანტების პროგრამას, რომელიც მხარს დაუჭერს ახალგაზრდა მხატვრებს და კრეატიულ პროექტებს. პროგრამა მოიცავს სხვადასხვა კატეგორიებს ხელოვნებისა და კრეატიული ინდუსტრიების სფეროში.\n\nპროგრამის ძირითადი მიმართულებები:\n• ვიზუალური ხელოვნება\n• მუსიკა და ხმოვანი ხელოვნება\n• ლიტერატურა და წერა\n• თეატრი და სცენური ხელოვნება\n• კინო და ვიდეო\n• ციფრული ხელოვნება',
                    'en' => 'Creative Georgia announces new grants program that will support young artists and creative projects. The program includes various categories in the arts and creative industries.\n\nMain program directions:\n• Visual Arts\n• Music and Audio Arts\n• Literature and Writing\n• Theater and Performing Arts\n• Film and Video\n• Digital Arts'
                ],
                'excerpt' => [
                    'ka' => 'ახალი გრანტების პროგრამა ახალგაზრდა მხატვრებისა და კრეატიული პროექტებისთვის',
                    'en' => 'New grants program for young artists and creative projects'
                ],
                'image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=400&h=300&fit=crop',
                'gallery' => [
                    'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1541961017774-22349e4a1262?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop'
                ],
                'published_at' => '2024-12-15',
                'category' => 'გრანტები',
                'author_id' => $admin?->id,
                'tags' => ['grants', 'artists', 'creative'],
                'view_count' => 1850,
                'is_featured' => true,
                'type' => 'news'
            ],
            [
                'slug' => 'international-art-festival-tbilisi',
                'title' => ['ka' => 'საერთაშორისო ხელოვნების ფესტივალი თბილისში', 'en' => 'International Art Festival in Tbilisi'],
                'content' => [
                    'ka' => 'თბილისში ჩატარდება საერთაშორისო ხელოვნების ფესტივალი, სადაც მონაწილეობას მიიღებენ 50-ზე მეტი ქვეყნის მხატვრები...',
                    'en' => 'An international art festival will be held in Tbilisi, featuring artists from over 50 countries...'
                ],
                'excerpt' => [
                    'ka' => 'საერთაშორისო ხელოვნების ფესტივალი 50-ზე მეტი ქვეყნის მონაწილეობით',
                    'en' => 'International art festival with participation from over 50 countries'
                ],
                'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=300&fit=crop',
                'published_at' => '2024-12-10',
                'category' => 'ღონისძიებები',
                'author_id' => $admin?->id,
                'tags' => ['festival', 'international', 'art'],
                'view_count' => 2350,
                'type' => 'news'
            ],
            // Continue with remaining news articles...
        ];

        foreach ($articles as $article) {
            NewsArticle::create($article);
        }
        
        $this->command->info('✓ Seeded news articles');
    }

    private function seedPressArticles()
    {
        $this->command->info('📺 Seeding press articles...');
        
        $admin = User::first();
        
        $pressArticles = [
            [
                'slug' => 'creative-georgia-annual-report-2024',
                'title' => ['ka' => 'შემოქმედებითი საქართველო წარმოადგენს 2024 წლის წლიურ ანგარიშს', 'en' => 'Creative Georgia Presents 2024 Annual Report'],
                'content' => [
                    'ka' => 'სსიპ შემოქმედებითი საქართველო წარმოადგენს 2024 წლის წლიურ ანგარიშს, რომელშიც წარმოდგენილია ორგანიზაციის საქმიანობის შედეგები, დაფინანსებული პროექტების მიმოხილვა და მიღწეული შედეგები. ანგარიშში ზედმიწევნით არის აღწერილი ყველა მთავარი პროექტი, რომელმაც წარმატებით განვითარება 2024 წელს. პროექტებში მონაწილეობდა 500-ზე მეტი კრეატორი და მხატვარი, რომლებმაც შექმნეს 100-ზე მეტი ნამუშევარი სხვადასხვა მიმართულებით.',
                    'en' => 'Creative Georgia presents its 2024 annual report, detailing the organization\'s activities, funded projects, and achievements. The report comprehensively covers all major projects that successfully developed in 2024. Over 500 creators and artists participated in projects, creating more than 100 works across various directions.'
                ],
                'excerpt' => [
                    'ka' => '2024 წლის წლიური ანგარიში: პროექტები, მიღწევები და განვითარება',
                    'en' => '2024 Annual Report: Projects, Achievements, and Development'
                ],
                'image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=400&h=300&fit=crop',
                'gallery' => [
                    'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1560170407-be019830343a?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=800&h=600&fit=crop',
                ],
                'published_at' => '2024-12-20',
                'category' => 'ანგარიშგება',
                'author_id' => $admin?->id,
                'tags' => ['report', 'annual', 'achievements'],
                'view_count' => 2450,
                'type' => 'press'
            ],
            // Continue with remaining press articles...
        ];

        foreach ($pressArticles as $article) {
            NewsArticle::create($article);
        }
        
        $this->command->info('✓ Seeded press articles');
    }

    private function seedEvents()
    {
        $this->command->info('📅 Seeding events...');
        
        $events = [
            [
                'slug' => 'creative-workshop-digital-art',
                'title' => ['ka' => 'კრეატიული ვორქშოპი: ციფრული ხელოვნება', 'en' => 'Creative Workshop: Digital Art'],
                'description' => [
                    'ka' => 'ციფრული ხელოვნების საფუძვლების შესწავლა პროფესიონალ მხატვართან ერთად. კურსში მოიცავს: პროგრამების გაცნობა, ციფრული ხატვის ტექნიკები, კომპოზიციის პრინციპები',
                    'en' => 'Learn the basics of digital art with professional artists. Course includes: software introduction, digital painting techniques, composition principles'
                ],
                'start_date' => '2025-10-15 10:00:00',
                'end_date' => '2025-10-15 16:00:00',
                'location' => 'შემოქმედებითი საქართველო Hub, Tbilisi',
                'capacity' => 25,
                'price' => 50.00,
                'is_free' => false,
                'image' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=400',
                'status' => 'upcoming'
            ],
            // Continue with remaining events...
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
        
        $this->command->info('✓ Seeded events');
    }

    private function seedSuccessStories()
    {
        $this->command->info('🌟 Seeding success stories...');
        
        $stories = [
            [
                'slug' => 'ana-javakhishvili',
                'title' => ['ka' => 'ანა ჯავახიშვილი', 'en' => 'Ana Javakhishvili'],
                'description' => [
                    'ka' => 'გრანტის მიღების შემდეგ გახსნა თანამედროვე ხელოვნების გალერეა თბილისში',
                    'en' => 'After receiving the grant, opened a contemporary art gallery in Tbilisi'
                ],
                'story' => [
                    'ka' => 'ანა ჯავახიშვილმა შემოქმედებითი საქართველოს მხარდაჭერით დააარსა თანამედროვე ხელოვნების გალერეა თბილისში. პროექტმა საშუალება მისცა ათობით ახალგაზრდა მხატვარს თავისი ნამუშევრების გამოფენას. დღეს გალერეა აქტიურად მუშაობს და საერთაშორისო დონეზე არის აღიარებული.',
                    'en' => 'Ana Javakhishvili founded a contemporary art gallery in Tbilisi with support from Creative Georgia. The project enabled dozens of young artists to exhibit their works. Today the gallery is actively operating and internationally recognized.'
                ],
                'achievements' => [
                    'გალერეის გახსნა თბილისში',
                    '100+ მხატვრის ნამუშევრის გამოფენა',
                    'საერთაშორისო აღიარება',
                    'კულტურული ღონისძიებების ორგანიზება'
                ],
                'image' => 'https://images.unsplash.com/photo-1544717297-fa95b6ee9643?w=400',
                'category' => 'ვიზუალური ხელოვნება',
                'competition_name' => 'თანამედროვე ხელოვნების განვითარების პროგრამა',
                'year' => 2023,
                'amount' => '₾50,000',
                'creator_name' => 'ანა ჯავახიშვილი',
                'is_featured' => true,
                'order' => 1
            ],
            [
                'slug' => 'giorgi-maisuradze',
                'title' => ['ka' => 'გიორგი მაისურაძე', 'en' => 'Giorgi Maisuradze'],
                'description' => [
                    'ka' => 'დოკუმენტური ფილმით მოიგო საერთაშორისო კინოფესტივალზე ჯილდო',
                    'en' => 'Won award at international film festival with documentary'
                ],
                'story' => [
                    'ka' => 'გიორგი მაისურაძემ შემოქმედებითი საქართველოს გრანტით შექმნა დოკუმენტური ფილმი ქართული კულტურის შესახებ.',
                    'en' => 'Giorgi Maisuradze created a documentary film about Georgian culture with a grant from Creative Georgia.'
                ],
                'achievements' => [
                    'საერთაშორისო ჯილდო',
                    'ფილმის პრემიერა',
                    'კინოფესტივალზე წარმოდგენა'
                ],
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400',
                'category' => 'Film',
                'competition_name' => 'Documentary Film Grant',
                'year' => 2023,
                'amount' => '₾30,000',
                'creator_name' => 'გიორგი მაისურაძე',
                'is_featured' => true,
                'order' => 2
            ],
            [
                'slug' => 'nino-khutateladze',
                'title' => ['ka' => 'ნინო ხუტელაძე', 'en' => 'Nino Khutateladze'],
                'description' => [
                    'ka' => 'ალბომის ჩაწერა და საერთაშორისო ტურნე',
                    'en' => 'Album recording and international tour'
                ],
                'story' => [
                    'ka' => 'ნინო ხუტელაძემ შემოქმედებითი საქართველოს მხარდაჭერით ჩაწერა პირველი ალბომი.',
                    'en' => 'Nino Khutateladze recorded her first album with support from Creative Georgia.'
                ],
                'achievements' => [
                    'ალბომის გამოშვება',
                    'საერთაშორისო ტურნე',
                    'მუსიკალური ჯილდოები'
                ],
                'image' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=400',
                'category' => 'Music',
                'competition_name' => 'Music Production Grant',
                'year' => 2023,
                'amount' => '₾20,000',
                'creator_name' => 'ნინო ხუტელაძე',
                'order' => 3
            ],
            [
                'slug' => 'davit-beruashvili',
                'title' => ['ka' => 'დავით ბერუაშვილი', 'en' => 'Davit Beruashvili'],
                'description' => [
                    'ka' => 'თეატრალური სპექტაკლის დადგმა და წარმოდგენა',
                    'en' => 'Staged and presented theatrical performance'
                ],
                'story' => [
                    'ka' => 'დავით ბერუაშვილმა შემოქმედებითი საქართველოს მხარდაჭერით დადგა თეატრალური სპექტაკლი.',
                    'en' => 'Davit Beruashvili staged a theatrical performance with support from Creative Georgia.'
                ],
                'achievements' => [
                    'სპექტაკლის დადგმა',
                    'წარმატებული პრემიერა',
                    'თეატრალური ჯილდო'
                ],
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400',
                'category' => 'Theater',
                'competition_name' => 'Theater Performance Competition',
                'year' => 2023,
                'amount' => '₾22,000',
                'creator_name' => 'დავით ბერუაშვილი',
                'order' => 4
            ],
            [
                'slug' => 'mariam-lortkipanidze',
                'title' => ['ka' => 'მარიამ ლორთქიფანიძე', 'en' => 'Mariam Lortkipanidze'],
                'description' => [
                    'ka' => 'პირველი წიგნის გამოცემა და ლიტერატურული ჯილდო',
                    'en' => 'Published first book and received literary award'
                ],
                'story' => [
                    'ka' => 'მარიამ ლორთქიფანიძემ შემოქმედებითი საქართველოს მხარდაჭერით გამოაქვეყნა პირველი წიგნი.',
                    'en' => 'Mariam Lortkipanidze published her first book with support from Creative Georgia.'
                ],
                'achievements' => [
                    'წიგნის გამოცემა',
                    'ლიტერატურული ჯილდო',
                    'კრიტიკოსთა აღიარება'
                ],
                'image' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?w=400',
                'category' => 'Literature',
                'competition_name' => 'Creative Writing Contest',
                'year' => 2023,
                'amount' => '₾10,000',
                'creator_name' => 'მარიამ ლორთქიფანიძე',
                'order' => 5
            ],
            [
                'slug' => 'luka-ghlonti',
                'title' => ['ka' => 'ლუკა ღლონტი', 'en' => 'Luka Ghlonti'],
                'description' => [
                    'ka' => 'ფოტოგრაფიული პროექტით წარმოდგენილი იქნა ნიუ-იორკის MoMA-ში',
                    'en' => 'Presented photography project at New York MoMA'
                ],
                'story' => [
                    'ka' => 'ლუკა ღლონტიმ შემოქმედებითი საქართველოს გრანტით შექმნა ფოტოგრაფიული პროექტი.',
                    'en' => 'Luka Ghlonti created a photography project with a grant from Creative Georgia.'
                ],
                'achievements' => [
                    'MoMA-ში წარმოდგენა',
                    'საერთაშორისო აღიარება',
                    'ფოტოგრაფიული პროექტის განვითარება'
                ],
                'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400',
                'category' => 'Photography',
                'competition_name' => 'Photography Exhibition Grant',
                'year' => 2023,
                'amount' => '₾12,000',
                'creator_name' => 'ლუკა ღლონტი',
                'order' => 6
            ]
        ];

        foreach ($stories as $story) {
            SuccessStory::create($story);
        }
        
        $this->command->info('✓ Seeded success stories');
    }

    private function seedFAQs()
    {
        $this->command->info('❓ Seeding FAQs...');
        
        $faqs = [
            [
                'question' => [
                    'ka' => 'როგორ შევძლებ განაცხადის შეტანას კონკურსზე?',
                    'en' => 'How can I apply for a competition?'
                ],
                'answer' => [
                    'ka' => 'განაცხადის შესატანად საჭიროა რეგისტრაცია ვებსაიტზე, შემდეგ კი კონკრეტული კონკურსის გვერდზე დააჭირეთ "განაცხადის შეტანა" ღილაკს და შეავსეთ საჭირო ველები. ყველა განაცხადი ავტომატურად იღებს უნიკალურ ნომერს.',
                    'en' => 'To apply, you need to register on the website, then go to the specific competition page and click "Apply" button. Fill out all required fields. Every application automatically receives a unique number.'
                ],
                'category' => 'Განაცხადების პროცესი',
                'order' => 1,
                'is_active' => true
            ],
            [
                'question' => [
                    'ka' => 'რა ტიპის დაფინანსებას ითვალისწინებს პროგრამა?',
                    'en' => 'What types of funding does the program provide?'
                ],
                'answer' => [
                    'ka' => 'პროგრამა ითვალისწინებს სხვადასხვა ტიპის დაფინანსებას: გრანტები, სტიპენდიები, პროექტური დაფინანსება. თანხის ოდენობა დამოკიდებულია პროექტის მასშტაბზე და კატეგორიაზე - ₾5,000-დან ₾50,000-მდე.',
                    'en' => 'The program provides various types of funding: grants, scholarships, project financing. The amount depends on project scale and category - from ₾5,000 to ₾50,000.'
                ],
                'category' => 'დაფინანსება',
                'order' => 2,
                'is_active' => true
            ],
            [
                'question' => [
                    'ka' => 'რამდენ ხანში მოხდება განაცხადის განხილვა?',
                    'en' => 'How long does the application review take?'
                ],
                'answer' => [
                    'ka' => 'განაცხადის განხილვა საშუალოდ 4-6 კვირას გრძელდება. პირველ ეტაპზე ხდება ფორმალური შემოწმება, შემდეგ - ექსპერტული შეფასება. განმცხადებლები ელფოსტით მიიღებენ შეტყობინებას შედეგების შესახებ.',
                    'en' => 'Application review takes approximately 4-6 weeks. First stage includes formal verification, followed by expert evaluation. Applicants will receive email notifications about results.'
                ],
                'category' => 'განხილვის პროცესი',
                'order' => 3,
                'is_active' => true
            ],
            [
                'question' => [
                    'ka' => 'შემიძლია თუ არა რამდენიმე კონკურსში ერთდროულად მონაწილეობა?',
                    'en' => 'Can I participate in multiple competitions simultaneously?'
                ],
                'answer' => [
                    'ka' => 'დიახ, შესაძლებელია რამდენიმე კონკურსში ერთდროულად მონაწილეობის მიღება, თუ პროექტები განსხვავებულია და შეესაბამება თითოეული კონკურსის მოთხოვნებს. თუმცა, ერთი პროექტისთვის არ არის დასაშვები ერთდროულად რამდენიმე გრანტის მიღება.',
                    'en' => 'Yes, you can participate in multiple competitions simultaneously if projects are different and meet each competition\'s requirements. However, receiving multiple grants for the same project is not allowed.'
                ],
                'category' => 'კონკურსის წესები',
                'order' => 4,
                'is_active' => true
            ],
            [
                'question' => [
                    'ka' => 'შემიძლია თუ არა გუნდურად განაცხადის შეტანა?',
                    'en' => 'Can I submit an application as a team?'
                ],
                'answer' => [
                    'ka' => 'დიახ, ბევრი კონკურსი იღებს როგორც ინდივიდუალურ, ასევე გუნდურ განაცხადებს. გუნდური პროექტის შემთხვევაში უნდა მიუთითოთ ყველა წევრის როლი და მათი წვლილი პროექტში. საჭიროა ერთი პასუხისმგებელი პირის განსაზღვრა.',
                    'en' => 'Yes, many competitions accept both individual and team applications. For team projects, you must specify each member\'s role and contribution. One responsible person must be designated.'
                ],
                'category' => 'გუნდური პროექტები',
                'order' => 5,
                'is_active' => true
            ],
            [
                'question' => [
                    'ka' => 'რა დოკუმენტაციაა საჭირო განაცხადის შესატანად?',
                    'en' => 'What documentation is required for application?'
                ],
                'answer' => [
                    'ka' => 'საჭირო დოკუმენტაცია მოიცავს: პროექტის აღწერილობა, ბიუჯეტი, განმცხადებლის CV/პორტფოლიო, რეკომენდაციის წერილები (თუ გააჩნია), პირადობის დამადასტურებელი დოკუმენტი. დამატებითი დოკუმენტები შეიძლება განსხვავდებოდეს კონკურსის მიხედვით.',
                    'en' => 'Required documentation includes: project description, budget, applicant\'s CV/portfolio, recommendation letters (if available), ID document. Additional documents may vary by competition.'
                ],
                'category' => 'დოკუმენტაცია',
                'order' => 6,
                'is_active' => true
            ]
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
        
        $this->command->info('✓ Seeded FAQs');
    }

    private function seedPartners()
    {
        $this->command->info('🤝 Seeding partners...');
        
        $partners = [
            [
                'name' => 'საქართველოს კულტურის სამინისტრო',
                'logo' => 'https://via.placeholder.com/200x100/1f2937/ffffff?text=Ministry+of+Culture',
                'website' => 'https://culture.gov.ge',
                'order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'თბილისის მერია',
                'logo' => 'https://via.placeholder.com/200x100/dc2626/ffffff?text=Tbilisi+City+Hall',
                'website' => 'https://tbilisi.gov.ge',
                'order' => 2,
                'is_active' => true
            ],
            // Continue with remaining partners...
        ];

        foreach ($partners as $partner) {
            Partner::create($partner);
        }
        
        $this->command->info('✓ Seeded partners');
    }

    private function seedHeroSliders()
    {
        $this->command->info('🎨 Seeding hero sliders...');
        
        $sliders = [
            [
                'title' => [
                    'ka' => 'შენი ნიჭი - ეროვნული ღირებულება',
                    'en' => 'Your Talent - National Treasure'
                ],
                'subtitle' => [
                    'ka' => 'ჩვენ ვართ ხიდი, რომელიც შემოქმედებით იდეებს სახელმწიფო რესურსებთან აკავშირებს და ზრუნავს მათ განხორციელებაზე. შემოგვიერთდით და განახორციელეთ თქვენი კრეატიული ოცნებები',
                    'en' => 'We are the bridge that connects creative ideas with state resources and ensures their implementation. Join us and realize your creative dreams'
                ],
                'category' => [
                    'ka' => 'შემოქმედებითი საქართველო',
                    'en' => 'Creative Georgia'
                ],
                'image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=1200&h=1600&fit=crop&crop=center',
                'location' => 'home',
                'order' => 1,
                'is_active' => true
            ],
            // Continue with remaining sliders...
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
        
        $this->command->info('✓ Seeded hero sliders');
    }

    private function seedMenus()
    {
        $this->command->info('🔗 Seeding menus...');
        
        // Header Menu
        $headerMenu = Menu::create([
            'name' => 'header-menu',
            'location' => 'header'
        ]);

        $menuItems = [
            ['title' => ['ka' => 'მთავარი', 'en' => 'Home'], 'url' => '/', 'order' => 1],
            ['title' => ['ka' => 'ჩვენ შესახებ', 'en' => 'About'], 'url' => '/about', 'order' => 2],
            ['title' => ['ka' => 'კონკურსები', 'en' => 'Competitions'], 'url' => '/competitions', 'order' => 3],
            ['title' => ['ka' => 'სიახლეები', 'en' => 'News'], 'url' => '/news', 'order' => 4],
            ['title' => ['ka' => 'ღონისძიებები', 'en' => 'Events'], 'url' => '/events', 'order' => 5],
            ['title' => ['ka' => 'რესურსები', 'en' => 'Resources'], 'url' => '/resources', 'order' => 6],
            ['title' => ['ka' => 'კონტაქტი', 'en' => 'Contact'], 'url' => '/contact', 'order' => 7],
        ];

        foreach ($menuItems as $item) {
            MenuItem::create([
                'menu_id' => $headerMenu->id,
                'title' => $item['title'],
                'url' => $item['url'],
                'order' => $item['order'],
                'is_active' => true
            ]);
        }

        // Footer Menu
        $footerMenu = Menu::create([
            'name' => 'footer-menu',
            'location' => 'footer'
        ]);

        $footerItems = [
            ['title' => ['ka' => 'ჩვენ შესახებ', 'en' => 'About Us'], 'url' => '/about', 'order' => 1],
            ['title' => ['ka' => 'კონკურსები', 'en' => 'Competitions'], 'url' => '/competitions', 'order' => 2],
            ['title' => ['ka' => 'სიახლეები', 'en' => 'News'], 'url' => '/news', 'order' => 3],
            ['title' => ['ka' => 'პრივატულობის პოლიტიკა', 'en' => 'Privacy Policy'], 'url' => '/privacy', 'order' => 4],
        ];

        foreach ($footerItems as $item) {
            MenuItem::create([
                'menu_id' => $footerMenu->id,
                'title' => $item['title'],
                'url' => $item['url'],
                'order' => $item['order'],
                'is_active' => true
            ]);
        }
        
        $this->command->info('✓ Seeded menus');
    }

    private function seedSettings()
    {
        $this->command->info('⚙️ Seeding settings...');
        
        $settings = [
            ['key' => 'site_name', 'value' => ['ka' => 'შემოქმედებითი საქართველო', 'en' => 'Creative Georgia'], 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => ['ka' => 'ხელოვნებისა და კრეატიული ინდუსტრიების მხარდაჭერა', 'en' => 'Supporting Arts and Creative Industries'], 'type' => 'text', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'info@creative-georgia.ge', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+995 32 2 123 456', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => ['ka' => 'თბილისი, რუსთაველის გამზირი 42', 'en' => '42 Rustaveli Avenue, Tbilisi, Georgia'], 'type' => 'text', 'group' => 'contact'],
            ['key' => 'map_lat', 'value' => '41.6938', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'map_lng', 'value' => '44.8015', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'primary_color', 'value' => '#024243', 'type' => 'color', 'group' => 'theme'],
            ['key' => 'secondary_color', 'value' => '#006ea5', 'type' => 'color', 'group' => 'theme'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
        
        // Update social links
        $socials = [
            ['platform' => 'facebook', 'url' => 'https://facebook.com/creativegeorgia', 'icon' => 'fab fa-facebook', 'order' => 1],
            ['platform' => 'instagram', 'url' => 'https://instagram.com/creativegeorgia', 'icon' => 'fab fa-instagram', 'order' => 2],
            ['platform' => 'linkedin', 'url' => 'https://linkedin.com/company/creative-georgia', 'icon' => 'fab fa-linkedin', 'order' => 3],
            ['platform' => 'twitter', 'url' => 'https://twitter.com/creativegeorgia', 'icon' => 'fab fa-twitter', 'order' => 4],
            ['platform' => 'youtube', 'url' => 'https://youtube.com/creativegeorgia', 'icon' => 'fab fa-youtube', 'order' => 5],
        ];

        foreach ($socials as $social) {
            SocialLink::updateOrCreate(
                ['platform' => $social['platform']],
                $social
            );
        }
        
        $this->command->info('✓ Seeded settings and social links');
    }
}

