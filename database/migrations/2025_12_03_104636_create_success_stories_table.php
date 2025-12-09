<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('success_stories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->json('title'); // {ka: '', en: ''}
            $table->json('description'); // {ka: '', en: ''}
            $table->json('story')->nullable(); // {ka: '', en: ''} - full story content
            $table->json('achievements')->nullable(); // JSON array of achievements
            $table->string('image')->nullable();
            $table->json('gallery')->nullable(); // array of images
            $table->string('category')->nullable();
            $table->string('competition_name')->nullable();
            $table->integer('year')->nullable();
            $table->string('amount')->nullable();
            $table->string('creator_name')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('success_stories');
    }
};
