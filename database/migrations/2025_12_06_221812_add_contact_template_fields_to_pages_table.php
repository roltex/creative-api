<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Contact Template Fields
            
            // Contact Form Section
            $table->json('contact_form_title')->nullable()->after('additional_info_button_url'); // {ka: '', en: ''}
            $table->json('contact_form_fields')->nullable()->after('contact_form_title'); // Array of form configuration
            
            // Contact Information Section
            $table->json('contact_info_title')->nullable()->after('contact_form_fields'); // {ka: '', en: ''}
            $table->json('contact_address')->nullable()->after('contact_info_title'); // {ka: '', en: ''}
            $table->string('contact_phone')->nullable()->after('contact_address');
            $table->string('contact_email')->nullable()->after('contact_phone');
            $table->json('office_hours_title')->nullable()->after('contact_email'); // {ka: '', en: ''}
            $table->json('office_hours_text')->nullable()->after('office_hours_title'); // {ka: '', en: ''}
            
            // Social Media Section
            $table->json('social_media_title')->nullable()->after('office_hours_text'); // {ka: '', en: ''}
            $table->json('social_media_links')->nullable()->after('social_media_title'); // Array of social links
            
            // Map Section
            $table->json('map_title')->nullable()->after('social_media_links'); // {ka: '', en: ''}
            $table->string('map_embed_url')->nullable()->after('map_title');
            $table->decimal('map_latitude', 10, 8)->nullable()->after('map_embed_url');
            $table->decimal('map_longitude', 11, 8)->nullable()->after('map_latitude');
            $table->integer('map_zoom')->default(16)->after('map_longitude');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'contact_form_title',
                'contact_form_fields',
                'contact_info_title',
                'contact_address',
                'contact_phone',
                'contact_email',
                'office_hours_title',
                'office_hours_text',
                'social_media_title',
                'social_media_links',
                'map_title',
                'map_embed_url',
                'map_latitude',
                'map_longitude',
                'map_zoom',
            ]);
        });
    }
};