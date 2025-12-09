<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Acts Template Fields
            
            // Legal Acts Section
            $table->json('legal_acts_title')->nullable()->after('achievements_list'); // {ka: '', en: ''}
            $table->json('legal_acts_list')->nullable()->after('legal_acts_title'); // Array of legal acts
            
            // Regulations Section
            $table->json('regulations_title')->nullable()->after('legal_acts_list'); // {ka: '', en: ''}
            $table->json('regulations_list')->nullable()->after('regulations_title'); // Array of regulations
            
            // Additional Information Section
            $table->json('additional_info_title')->nullable()->after('regulations_list'); // {ka: '', en: ''}
            $table->json('additional_info_content')->nullable()->after('additional_info_title'); // {ka: '', en: ''}
            $table->json('additional_info_button_text')->nullable()->after('additional_info_content'); // {ka: '', en: ''}
            $table->string('additional_info_button_url')->nullable()->after('additional_info_button_text');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'legal_acts_title',
                'legal_acts_list',
                'regulations_title',
                'regulations_list',
                'additional_info_title',
                'additional_info_content',
                'additional_info_button_text',
                'additional_info_button_url',
            ]);
        });
    }
};