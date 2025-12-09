<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // {ka: '', en: ''}
            $table->json('subtitle')->nullable(); // {ka: '', en: ''}
            $table->json('category')->nullable(); // {ka: '', en: ''}
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->string('button_text')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('location')->default('home'); // home, about, etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
