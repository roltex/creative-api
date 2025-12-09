<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->json('title'); // {ka: '', en: ''}
            $table->json('description'); // {ka: '', en: ''}
            $table->enum('status', ['current', 'upcoming', 'completed', 'evaluating'])->default('current');
            $table->date('start_date');
            $table->date('end_date');
            $table->json('criteria')->nullable(); // {ka: '', en: ''}
            $table->json('rules')->nullable(); // {ka: '', en: ''}
            $table->string('category')->nullable();
            $table->string('prize')->nullable();
            $table->integer('max_participants')->nullable();
            $table->integer('current_participants')->default(0);
            $table->string('image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('competitions');
    }
};
