<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class HomepageSetting extends Model
{
    use HasTranslations;

    protected $table = 'homepage_settings';

    public $translatable = [
        'competitions_title',
        'news_title',
        'events_title',
        'success_stories_title',
        'cta_title',
        'cta_subtitle',
        'cta_button_text',
    ];

    protected $fillable = [
        'show_hero_banner',
        'show_cta',
        'show_competitions',
        'show_news',
        'show_events',
        'show_success_stories',
        'competitions_title',
        'news_title',
        'events_title',
        'success_stories_title',
        'cta_title',
        'cta_subtitle',
        'cta_button_text',
        'cta_button_url',
        'cta_stats',
    ];

    protected $casts = [
        'show_hero_banner' => 'boolean',
        'show_cta' => 'boolean',
        'show_competitions' => 'boolean',
        'show_news' => 'boolean',
        'show_events' => 'boolean',
        'show_success_stories' => 'boolean',
        'cta_stats' => 'array',
    ];

    public static function instance(): self
    {
        $instance = static::first();

        if (!$instance) {
            $instance = static::create([
                'show_hero_banner' => true,
                'show_cta' => true,
                'show_competitions' => true,
                'show_news' => true,
                'show_events' => true,
                'show_success_stories' => false,
                'competitions_title' => ['ka' => 'მიმდინარე კონკურსები', 'en' => 'Current Competitions'],
                'news_title' => ['ka' => 'უახლესი სიახლეები', 'en' => 'Latest News'],
                'events_title' => ['ka' => 'მოახლოებული ღონისძიებები', 'en' => 'Upcoming Events'],
                'success_stories_title' => ['ka' => 'წარმატებული ისტორიები', 'en' => 'Success Stories'],
                'cta_title' => ['ka' => 'მზად ხარ შემოქმედებითი მოგზაურობისთვის?', 'en' => 'Ready for a Creative Journey?'],
                'cta_subtitle' => ['ka' => 'შემოუერთდი ათასობით მხატვარს და შემოქმედს, რომლებმაც ჩვენი მხარდაჭერით თავიანთი იდეები რეალობად აქციეს', 'en' => 'Join thousands of artists and creators who turned their ideas into reality with our support'],
                'cta_button_text' => ['ka' => 'შეავსე განაცხადის ფორმა', 'en' => 'Fill Application Form'],
                'cta_button_url' => '/application/step-1',
                'cta_stats' => [
                    ['value' => '1', 'suffix' => 'K+', 'label' => ['ka' => 'მხარდაჭერილი პროექტი', 'en' => 'Supported Projects']],
                    ['value' => '500', 'suffix' => '+', 'label' => ['ka' => 'წარმატებული შემოქმედი', 'en' => 'Successful Creators']],
                    ['value' => '50', 'suffix' => 'M+', 'label' => ['ka' => 'ლარი დაფინანსება', 'en' => 'GEL Funding']],
                ],
            ]);
        }

        return $instance;
    }
}
