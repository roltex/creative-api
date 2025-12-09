<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Reports Template Fields
            
            // Annual Reports Section
            $table->json('annual_reports_title')->nullable()->after('sections'); // {ka: '', en: ''}
            $table->json('annual_reports_list')->nullable()->after('annual_reports_title'); // Array of reports
            
            // Strategic Plans Section
            $table->json('strategic_plans_title')->nullable()->after('annual_reports_list'); // {ka: '', en: ''}
            $table->json('strategic_plans_list')->nullable()->after('strategic_plans_title'); // Array of plans
            
            // Financial Reports Section
            $table->json('financial_reports_title')->nullable()->after('strategic_plans_list'); // {ka: '', en: ''}
            $table->json('financial_reports_list')->nullable()->after('financial_reports_title'); // Array of reports
            
            // Key Achievements Section (reuse stats from mission)
            $table->json('achievements_title')->nullable()->after('financial_reports_list'); // {ka: '', en: ''}
            $table->json('achievements_list')->nullable()->after('achievements_title'); // Array of achievements
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'annual_reports_title',
                'annual_reports_list',
                'strategic_plans_title',
                'strategic_plans_list',
                'financial_reports_title',
                'financial_reports_list',
                'achievements_title',
                'achievements_list',
            ]);
        });
    }
};