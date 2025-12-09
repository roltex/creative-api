<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // {ka: '', en: ''}
            $table->json('description')->nullable(); // {ka: '', en: ''}
            $table->string('file_path')->nullable();
            $table->string('file_type')->nullable(); // pdf, doc, image, etc.
            $table->integer('file_size')->nullable(); // in bytes
            $table->string('category')->nullable(); // guidelines, templates, acts, etc.
            $table->string('url')->nullable(); // external URL if not a file
            $table->integer('download_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
