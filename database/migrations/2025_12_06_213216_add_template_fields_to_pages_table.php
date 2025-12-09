<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Hero Section
            $table->json('hero_subtitle')->nullable()->after('template'); // {ka: '', en: ''}
            
            // Mission Section (for mission template)
            $table->json('mission_title')->nullable()->after('hero_subtitle'); // {ka: '', en: ''}
            $table->json('mission_content')->nullable()->after('mission_title'); // {ka: '', en: ''}
            $table->json('mission_content_2')->nullable()->after('mission_content'); // {ka: '', en: ''}
            
            // Goals Section
            $table->json('goals_title')->nullable()->after('mission_content_2'); // {ka: '', en: ''}
            $table->json('goals_content')->nullable()->after('goals_title'); // {ka: '', en: ''}
            $table->json('goals_list')->nullable()->after('goals_content'); // Array of goals [{ka: '', en: ''}]
            
            // Values Section
            $table->json('values_title')->nullable()->after('goals_list'); // {ka: '', en: ''}
            $table->json('values_list')->nullable()->after('values_title'); // Array of values with title and description
            
            // Stats/Achievements Section
            $table->json('stats_title')->nullable()->after('values_list'); // {ka: '', en: ''}
            $table->json('stats_list')->nullable()->after('stats_title'); // Array of statistics [{number: '', label: {ka: '', en: ''}}]
            
            // Additional Template Fields
            $table->json('sections')->nullable()->after('stats_list'); // Generic sections for flexible templates
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'hero_subtitle',
                'mission_title',
                'mission_content',
                'mission_content_2',
                'goals_title',
                'goals_content',
                'goals_list',
                'values_title',
                'values_list',
                'stats_title',
                'stats_list',
                'sections',
            ]);
        });
    }
};