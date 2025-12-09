<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->json('title'); // {ka: '', en: ''}
            $table->json('content')->nullable(); // {ka: '', en: ''}
            $table->json('meta_title')->nullable(); // {ka: '', en: ''}
            $table->json('meta_description')->nullable(); // {ka: '', en: ''}
            $table->string('template')->default('default');
            $table->enum('status', ['draft', 'published', 'archived'])->default('published');
            $table->boolean('is_homepage')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
