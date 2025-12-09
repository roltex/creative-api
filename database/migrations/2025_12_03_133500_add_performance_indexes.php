<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add indexes for frequently queried columns
        Schema::table('competitions', function (Blueprint $table) {
            $table->index('status');
            $table->index('is_featured');
            $table->index(['status', 'is_featured']);
        });

        Schema::table('news_articles', function (Blueprint $table) {
            $table->index('type');
            $table->index('is_featured');
            $table->index('published_at');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->index('status');
            $table->index('is_featured');
            $table->index('start_date');
        });

        Schema::table('success_stories', function (Blueprint $table) {
            $table->index('is_featured');
            $table->index('order');
        });

        Schema::table('faqs', function (Blueprint $table) {
            $table->index('is_active');
            $table->index('order');
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->index('is_active');
            $table->index('order');
        });

        Schema::table('sliders', function (Blueprint $table) {
            $table->index('is_active');
            $table->index('location');
            $table->index(['location', 'is_active']);
        });

        Schema::table('social_links', function (Blueprint $table) {
            $table->index('is_active');
            $table->index('order');
        });

        Schema::table('menu_items', function (Blueprint $table) {
            $table->index('menu_id');
            $table->index('parent_id');
            $table->index('is_active');
            $table->index(['menu_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::table('competitions', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['status', 'is_featured']);
        });

        Schema::table('news_articles', function (Blueprint $table) {
            $table->dropIndex(['type']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['published_at']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['start_date']);
        });

        Schema::table('success_stories', function (Blueprint $table) {
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['order']);
        });

        Schema::table('faqs', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['order']);
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['order']);
        });

        Schema::table('sliders', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['location']);
            $table->dropIndex(['location', 'is_active']);
        });

        Schema::table('social_links', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['order']);
        });

        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropIndex(['menu_id']);
            $table->dropIndex(['parent_id']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['menu_id', 'is_active']);
        });
    }
};

