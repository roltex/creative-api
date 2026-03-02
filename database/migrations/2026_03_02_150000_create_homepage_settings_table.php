<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homepage_settings', function (Blueprint $table) {
            $table->id();

            // Section visibility
            $table->boolean('show_hero_banner')->default(true);
            $table->boolean('show_cta')->default(true);
            $table->boolean('show_competitions')->default(true);
            $table->boolean('show_news')->default(true);
            $table->boolean('show_events')->default(true);
            $table->boolean('show_success_stories')->default(false);

            // Section titles (translatable JSON)
            $table->json('competitions_title')->nullable();
            $table->json('news_title')->nullable();
            $table->json('events_title')->nullable();
            $table->json('success_stories_title')->nullable();

            // CTA section
            $table->json('cta_title')->nullable();
            $table->json('cta_subtitle')->nullable();
            $table->json('cta_button_text')->nullable();
            $table->string('cta_button_url')->nullable();
            $table->json('cta_stats')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_settings');
    }
};
