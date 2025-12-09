<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presses', function (Blueprint $table) {
            $table->id();
            $table->json('press_title'); // {ka: '', en: ''} - პრეს-რელიზის სათაური
            $table->string('media_name'); // მედიის დასახელება
            $table->string('media_link')->nullable(); // ბმული
            $table->string('media_logo')->nullable(); // მედიის ლოგო
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presses');
    }
};