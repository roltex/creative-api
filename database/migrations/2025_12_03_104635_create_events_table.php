<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->json('title'); // {ka: '', en: ''}
            $table->json('description'); // {ka: '', en: ''}
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->json('location')->nullable(); // {ka: '', en: ''}
            $table->string('image')->nullable();
            $table->integer('capacity')->nullable();
            $table->integer('registered_count')->default(0);
            $table->decimal('price', 10, 2)->nullable();
            $table->boolean('is_free')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
