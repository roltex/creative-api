<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_articles', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->json('title'); // {ka: '', en: ''}
            $table->json('content'); // {ka: '', en: ''}
            $table->json('excerpt')->nullable(); // {ka: '', en: ''}
            $table->string('image')->nullable();
            $table->json('gallery')->nullable(); // array of image URLs
            $table->date('published_at');
            $table->string('category')->nullable();
            $table->foreignId('author_id')->nullable()->constrained('users')->onDelete('set null');
            $table->json('tags')->nullable(); // array of tags
            $table->integer('view_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_press')->default(false); // distinguish between news and press
            $table->string('type')->default('news'); // news, press
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_articles');
    }
};
