<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class ContactPageSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('📞 Seeding Contact page...');
        
        $contactPage = Page::updateOrCreate(
            ['slug' => 'contact'],
            [
                'title' => [
                    'ka' => 'კონტაქტი',
                    'en' => 'Contact'
                ],
                'subtitle' => [
                    'ka' => 'დაგვიკავშირდით და ჩვენი გუნდი დაგეხმარებათ',
                    'en' => 'Contact us and our team will help you'
                ],
                'template' => 'contact',
                'status' => 'published',
                'order' => 4,
                
                // Contact Form Section
                'contact_form_title' => [
                    'ka' => 'გამოგვიგზავნეთ შეტყობინება',
                    'en' => 'Send Us a Message'
                ],
                'contact_form_fields' => [
                    [
                        'name' => 'name',
                        'label_ka' => 'სახელი და გვარი',
                        'label_en' => 'Full Name',
                        'type' => 'text',
                        'required' => true,
                        'placeholder_ka' => 'შეიყვანეთ თქვენი სახელი',
                        'placeholder_en' => 'Enter your name'
                    ],
                    [
                        'name' => 'email',
                        'label_ka' => 'ელ.ფოსტა',
                        'label_en' => 'Email',
                        'type' => 'email',
                        'required' => true,
                        'placeholder_ka' => 'example@email.com',
                        'placeholder_en' => 'example@email.com'
                    ],
                    [
                        'name' => 'phone',
                        'label_ka' => 'ტელეფონი',
                        'label_en' => 'Phone',
                        'type' => 'tel',
                        'required' => false,
                        'placeholder_ka' => '+995 XXX XX XX XX',
                        'placeholder_en' => '+995 XXX XX XX XX'
                    ],
                    [
                        'name' => 'subject',
                        'label_ka' => 'თემა',
                        'label_en' => 'Subject',
                        'type' => 'select',
                        'required' => true,
                        'options' => [
                            ['value' => 'competition', 'label_ka' => 'კონკურსების შესახებ', 'label_en' => 'About Competitions'],
                            ['value' => 'funding', 'label_ka' => 'დაფინანსების შესახებ', 'label_en' => 'About Funding'],
                            ['value' => 'partnership', 'label_ka' => 'პარტნიორობა', 'label_en' => 'Partnership'],
                            ['value' => 'general', 'label_ka' => 'სხვა კითხვა', 'label_en' => 'Other Question']
                        ]
                    ],
                    [
                        'name' => 'message',
                        'label_ka' => 'შეტყობინება',
                        'label_en' => 'Message',
                        'type' => 'textarea',
                        'required' => true,
                        'placeholder_ka' => 'დაწერეთ თქვენი შეტყობინება...',
                        'placeholder_en' => 'Write your message...'
                    ]
                ],
                
                // Contact Information Section
                'contact_info_title' => [
                    'ka' => 'საკონტაქტო ინფორმაცია',
                    'en' => 'Contact Information'
                ],
                'contact_address' => [
                    'ka' => 'თბილისი, რუსთაველის გამზირი 42<br />საქართველო',
                    'en' => '42 Rustaveli Avenue, Tbilisi<br />Georgia'
                ],
                'contact_phone' => '+995 32 2 123 456',
                'contact_email' => 'info@creative-georgia.ge',
                'office_hours_title' => [
                    'ka' => 'სამუშაო საათები',
                    'en' => 'Office Hours'
                ],
                'office_hours_text' => [
                    'ka' => 'ორშაბათი - პარასკევი: 10:00 - 18:00<br />შაბათი - კვირა: დახურული',
                    'en' => 'Monday - Friday: 10:00 - 18:00<br />Saturday - Sunday: Closed'
                ],
                
                // Social Media Section
                'social_media_title' => [
                    'ka' => 'გამოგვყევით',
                    'en' => 'Follow Us'
                ],
                'social_media_links' => [
                    [
                        'platform' => 'facebook',
                        'url' => 'https://facebook.com/creativegeorgia',
                        'icon_class' => 'lucide-facebook'
                    ],
                    [
                        'platform' => 'instagram',
                        'url' => 'https://instagram.com/creativegeorgia',
                        'icon_class' => 'lucide-instagram'
                    ],
                    [
                        'platform' => 'linkedin',
                        'url' => 'https://linkedin.com/company/creative-georgia',
                        'icon_class' => 'lucide-linkedin'
                    ],
                    [
                        'platform' => 'youtube',
                        'url' => 'https://youtube.com/creativegeorgia',
                        'icon_class' => 'lucide-youtube'
                    ]
                ],
                
                // Map Section
                'map_title' => [
                    'ka' => 'ადგილმდებარეობა',
                    'en' => 'Location'
                ],
                'map_embed_url' => 'https://maps.google.com/maps?q=42+Rustaveli+Avenue,+Tbilisi,+Georgia&t=&z=16&ie=UTF8&iwloc=&output=embed',
                'map_latitude' => 41.6938,
                'map_longitude' => 44.8015,
                'map_zoom' => 16,
                
                // SEO
                'meta_title' => [
                    'ka' => 'კონტაქტი - შემოქმედებითი საქართველო',
                    'en' => 'Contact - Creative Georgia'
                ],
                'meta_description' => [
                    'ka' => 'დაგვიკავშირდით შემოქმედებითი საქართველოს. ჩვენი მისამართი, ტელეფონი, ელფოსტა და სამუშაო საათები.',
                    'en' => 'Contact Creative Georgia. Our address, phone, email and office hours.'
                ]
            ]
        );
        
        $this->command->info('✓ Contact page created/updated');
        $this->command->info("Contact page accessible at: /pages/{$contactPage->slug}");
        $this->command->info('📞 Contact template includes:');
        $this->command->info('  - Contact form with ' . count($contactPage->contact_form_fields) . ' fields');
        $this->command->info('  - Contact information (address, phone, email, hours)');
        $this->command->info('  - Social media links (' . count($contactPage->social_media_links) . ' platforms)');
        $this->command->info('  - Map section with coordinates');
    }
}