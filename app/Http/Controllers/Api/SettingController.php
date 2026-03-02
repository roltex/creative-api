<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HomepageSetting;
use App\Models\Page;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $contactData = $this->getContactFromPage();
        $homepageData = $this->getHomepageSettings();

        $settings = [
            'site' => [
                'name' => [
                    'ka' => 'შემოქმედებითი საქართველო',
                    'en' => 'Creative Georgia'
                ],
                'tagline' => [
                    'ka' => 'კრეატიული ინდუსტრიების მხარდაჭერა',
                    'en' => 'Supporting Creative Industries'
                ],
                'description' => [
                    'ka' => 'შემოქმედებითი საქართველო არის ქართული კრეატიული ინდუსტრიების განვითარების მხარდამჭერი ორგანიზაცია.',
                    'en' => 'Creative Georgia is an organization supporting the development of Georgian creative industries.'
                ]
            ],
            'contact' => $contactData,
            'social' => [
                'facebook' => 'https://facebook.com/creativegeorgia',
                'instagram' => 'https://instagram.com/creativegeorgia',
                'linkedin' => 'https://linkedin.com/company/creative-georgia',
                'twitter' => 'https://twitter.com/creativegeorgia',
                'youtube' => 'https://youtube.com/creativegeorgia'
            ],
            'theme' => [
                'primary_color' => '#024243',
                'secondary_color' => '#006ea5',
                'success_color' => '#10b981',
                'warning_color' => '#f59e0b',
                'error_color' => '#ef4444'
            ],
            'features' => [
                'enable_registration' => true,
                'enable_newsletter' => true,
                'enable_file_uploads' => true,
                'max_file_size' => 10485760,
                'allowed_file_types' => [
                    'application/pdf',
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                ]
            ],
            'statistics' => [
                'supported_projects' => 1000,
                'successful_creators' => 500,
                'total_funding' => 50000000
            ],
            'map' => [
                'latitude' => 41.6938,
                'longitude' => 44.8015,
                'zoom' => 15
            ],
            'homepage' => $homepageData,
        ];

        return response()->json([
            'success' => true,
            'data' => $settings
        ]);
    }

    public function getByGroup($group)
    {
        $settings = $this->index()->getData(true);
        
        if (!isset($settings['data'][$group])) {
            return response()->json([
                'success' => false,
                'message' => 'Settings group not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $settings['data'][$group]
        ]);
    }

    private function getContactFromPage(): array
    {
        $fallback = [
            'email' => 'info@creative-georgia.ge',
            'phone' => '+995 32 2 123 456',
            'address' => [
                'ka' => 'თბილისი, რუსთაველის გამზირი 42',
                'en' => '42 Rustaveli Avenue, Tbilisi, Georgia'
            ],
            'working_hours' => [
                'ka' => 'ორშაბათი-პარასკევი: 09:00-18:00',
                'en' => 'Monday-Friday: 09:00-18:00'
            ]
        ];

        try {
            $contactPage = Page::where('template', 'contact')
                ->where('status', 'published')
                ->first();

            if (!$contactPage) {
                return $fallback;
            }

            $parseTranslatable = function ($value) {
                if (empty($value)) return ['ka' => '', 'en' => ''];
                if (is_array($value) && (isset($value['ka']) || isset($value['en']))) {
                    return ['ka' => $value['ka'] ?? '', 'en' => $value['en'] ?? ''];
                }
                $decoded = is_string($value) ? json_decode($value, true) : $value;
                if (is_array($decoded)) {
                    return ['ka' => $decoded['ka'] ?? $decoded['ge'] ?? '', 'en' => $decoded['en'] ?? ''];
                }
                return ['ka' => (string) $value, 'en' => (string) $value];
            };

            $address = $contactPage->contact_address
                ? $parseTranslatable($contactPage->contact_address)
                : $fallback['address'];

            $workingHours = $contactPage->office_hours_text
                ? $parseTranslatable($contactPage->office_hours_text)
                : $fallback['working_hours'];

            return [
                'email' => $contactPage->contact_email ?: $fallback['email'],
                'phone' => $contactPage->contact_phone ?: $fallback['phone'],
                'address' => $address,
                'working_hours' => $workingHours,
            ];
        } catch (\Exception $e) {
            return $fallback;
        }
    }

    private function getHomepageSettings(): array
    {
        try {
            $hp = HomepageSetting::instance();

            $trans = function (string $field) use ($hp): array {
                return [
                    'ka' => $hp->getTranslation($field, 'ka'),
                    'en' => $hp->getTranslation($field, 'en'),
                ];
            };

            return [
                'sections' => [
                    'hero_banner' => $hp->show_hero_banner,
                    'cta' => $hp->show_cta,
                    'competitions' => [
                        'visible' => $hp->show_competitions,
                        'title' => $trans('competitions_title'),
                    ],
                    'news' => [
                        'visible' => $hp->show_news,
                        'title' => $trans('news_title'),
                    ],
                    'events' => [
                        'visible' => $hp->show_events,
                        'title' => $trans('events_title'),
                    ],
                    'success_stories' => [
                        'visible' => $hp->show_success_stories,
                        'title' => $trans('success_stories_title'),
                    ],
                ],
                'cta' => [
                    'title' => $trans('cta_title'),
                    'subtitle' => $trans('cta_subtitle'),
                    'button_text' => $trans('cta_button_text'),
                    'button_url' => $hp->cta_button_url ?? '/application/step-1',
                    'stats' => $hp->cta_stats ?? [],
                ],
            ];
        } catch (\Exception $e) {
            return [
                'sections' => [
                    'hero_banner' => true,
                    'cta' => true,
                    'competitions' => ['visible' => true, 'title' => ['ka' => 'მიმდინარე კონკურსები', 'en' => 'Current Competitions']],
                    'news' => ['visible' => true, 'title' => ['ka' => 'უახლესი სიახლეები', 'en' => 'Latest News']],
                    'events' => ['visible' => true, 'title' => ['ka' => 'მოახლოებული ღონისძიებები', 'en' => 'Upcoming Events']],
                    'success_stories' => ['visible' => false, 'title' => ['ka' => 'წარმატებული ისტორიები', 'en' => 'Success Stories']],
                ],
                'cta' => [
                    'title' => ['ka' => 'მზად ხარ შემოქმედებითი მოგზაურობისთვის?', 'en' => 'Ready for a Creative Journey?'],
                    'subtitle' => ['ka' => 'შემოუერთდი ათასობით მხატვარს და შემოქმედს', 'en' => 'Join thousands of artists and creators'],
                    'button_text' => ['ka' => 'შეავსე განაცხადის ფორმა', 'en' => 'Fill Application Form'],
                    'button_url' => '/application/step-1',
                    'stats' => [
                        ['value' => '1', 'suffix' => 'K+', 'label' => ['ka' => 'მხარდაჭერილი პროექტი', 'en' => 'Supported Projects']],
                        ['value' => '500', 'suffix' => '+', 'label' => ['ka' => 'წარმატებული შემოქმედი', 'en' => 'Successful Creators']],
                        ['value' => '50', 'suffix' => 'M+', 'label' => ['ka' => 'ლარი დაფინანსება', 'en' => 'GEL Funding']],
                    ],
                ],
            ];
        }
    }
}