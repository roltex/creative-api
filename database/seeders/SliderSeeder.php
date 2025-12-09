<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🎞️ Seeding Hero Sliders...');
        
        // Clear existing sliders
        Slider::truncate();
        
        $sliders = [
            [
                'title' => [
                    'ka' => 'შენი ნიჭი - ეროვნული ღირებულება',
                    'en' => 'Your Talent - National Treasure'
                ],
                'subtitle' => [
                    'ka' => 'ჩვენ ვართ ხიდი, რომელიც შემოქმედებით იდეებს სახელმწიფო რესურსებთან აკავშირებს და ზრუნავს მათ განხორციელებაზე',
                    'en' => 'We are the bridge that connects creative ideas with state resources and ensures their implementation'
                ],
                'category' => [
                    'ka' => 'შემოქმედებითი საქართველო',
                    'en' => 'Creative Georgia'
                ],
                'button_text' => 'მონაწილეობის განაცხადი',
                'link' => '/application/step-1',
                'image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=1200&h=1600&fit=crop',
                'location' => 'home',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => [
                    'ka' => 'კონკურსები და გრანტები',
                    'en' => 'Competitions and Grants'
                ],
                'subtitle' => [
                    'ka' => 'იდეიდან განხორციელებამდე - ჩვენ გთავაზობთ სრულ მხარდაჭერას თქვენი შემოქმედებითი პროექტებისთვის',
                    'en' => 'From idea to implementation - we offer complete support for your creative projects'
                ],
                'category' => [
                    'ka' => 'დაფინანსება',
                    'en' => 'Funding'
                ],
                'button_text' => 'კონკურსების ნახვა',
                'link' => '/competitions',
                'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1200&h=1600&fit=crop',
                'location' => 'home',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => [
                    'ka' => 'შემოქმედთა საზოგადოება',
                    'en' => 'Creators Community'
                ],
                'subtitle' => [
                    'ka' => '1000+ შემოქმედი უკვე ნდობს ჩვენს პლატფორმას. გახდი ნაწილი ქართული კულტურის განვითარების მისიისა',
                    'en' => '1000+ creators already trust our platform. Become part of the mission to develop Georgian culture'
                ],
                'category' => [
                    'ka' => 'საზოგადოება',
                    'en' => 'Community'
                ],
                'button_text' => 'შემოგვიერთდი',
                'link' => '/auth/register',
                'image' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?w=1200&h=1600&fit=crop',
                'location' => 'home',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => [
                    'ka' => 'ციფრული ხელოვნება',
                    'en' => 'Digital Art'
                ],
                'subtitle' => [
                    'ka' => 'თანამედროვე ტექნოლოგიები და ციფრული ხელოვნება - ვხმარობთ ინოვაციურ მეთოდებს კრეატიული ინდუსტრიების განვითარებისთვის',
                    'en' => 'Modern technologies and digital art - we use innovative methods for creative industry development'
                ],
                'category' => [
                    'ka' => 'ინოვაცია',
                    'en' => 'Innovation'
                ],
                'button_text' => 'ციფრული პროექტები',
                'link' => '/competitions',
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200&h=1600&fit=crop',
                'location' => 'home',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'title' => [
                    'ka' => 'წარმატების ისტორიები',
                    'en' => 'Success Stories'
                ],
                'subtitle' => [
                    'ka' => 'აღმოაჩინეთ შთამბეჭდავი პროექტები და ნიჭიერი შემოქმედები, რომლებმაც წარმატებით განახორციელეს თავიანთი იდეები',
                    'en' => 'Discover impressive projects and talented creators who successfully implemented their ideas'
                ],
                'category' => [
                    'ka' => 'შთაგონება',
                    'en' => 'Inspiration'
                ],
                'button_text' => 'წარმატების ისტორიები',
                'link' => '/success-stories',
                'image' => 'https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8b?w=1200&h=1600&fit=crop',
                'location' => 'home',
                'order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
        
        $this->command->info('✓ Seeded ' . count($sliders) . ' hero sliders');
        $this->command->info('  - All sliders for homepage');
        $this->command->info('  - Georgian/English content');
        $this->command->info('  - Call-to-action buttons');
    }
}