<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasTranslations;

    public $translatable = [
        'title', 
        'subtitle',
        'content', 
        'meta_title', 
        'meta_description',
        'hero_subtitle',
        'mission_title',
        'mission_content',
        'mission_content_2',
        'goals_title',
        'goals_content',
        'values_title',
        'stats_title',
        'annual_reports_title',
        'strategic_plans_title',
        'financial_reports_title',
        'achievements_title',
        'legal_acts_title',
        'regulations_title',
        'additional_info_title',
        'additional_info_content',
        'additional_info_button_text',
        'contact_form_title',
        'contact_info_title',
        'contact_address',
        'office_hours_title',
        'office_hours_text',
        'social_media_title',
        'map_title'
    ];

    protected $fillable = [
        'slug', 'title', 'subtitle', 'content', 'meta_title', 'meta_description', 
        'template', 'status', 'is_homepage', 'order',
        'hero_subtitle', 'mission_title', 'mission_content', 'mission_content_2',
        'goals_title', 'goals_content', 'goals_list',
        'values_title', 'values_list',
        'stats_title', 'stats_list',
        'annual_reports_title', 'annual_reports_list',
        'strategic_plans_title', 'strategic_plans_list',
        'financial_reports_title', 'financial_reports_list',
        'achievements_title', 'achievements_list',
        'legal_acts_title', 'legal_acts_list',
        'regulations_title', 'regulations_list',
        'additional_info_title', 'additional_info_content', 'additional_info_button_text', 'additional_info_button_url',
        'contact_form_title', 'contact_form_fields',
        'contact_info_title', 'contact_address', 'contact_phone', 'contact_email',
        'office_hours_title', 'office_hours_text',
        'social_media_title', 'social_media_links',
        'map_title', 'map_embed_url', 'map_latitude', 'map_longitude', 'map_zoom',
        'sections'
    ];

    protected $casts = [
        'is_homepage' => 'boolean',
        'order' => 'integer',
        'goals_list' => 'array',
        'values_list' => 'array',
        'stats_list' => 'array',
        'annual_reports_list' => 'array',
        'strategic_plans_list' => 'array',
        'financial_reports_list' => 'array',
        'achievements_list' => 'array',
        'legal_acts_list' => 'array',
        'regulations_list' => 'array',
        'contact_form_fields' => 'array',
        'social_media_links' => 'array',
        'map_latitude' => 'decimal:8',
        'map_longitude' => 'decimal:8',
        'map_zoom' => 'integer',
        'sections' => 'array',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
