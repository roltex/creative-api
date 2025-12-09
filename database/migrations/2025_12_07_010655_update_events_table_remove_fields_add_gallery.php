<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Add gallery column
            $table->json('gallery')->nullable()->after('image');
        });
        
        // Remove unwanted columns
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'capacity')) {
                $table->dropColumn('capacity');
            }
            if (Schema::hasColumn('events', 'registered_count')) {
                $table->dropColumn('registered_count');
            }
            if (Schema::hasColumn('events', 'price')) {
                $table->dropColumn('price');
            }
            if (Schema::hasColumn('events', 'is_free')) {
                $table->dropColumn('is_free');
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Add back removed columns
            $table->integer('capacity')->nullable();
            $table->integer('registered_count')->default(0);
            $table->decimal('price', 10, 2)->nullable();
            $table->boolean('is_free')->default(true);
        });
        
        Schema::table('events', function (Blueprint $table) {
            // Remove gallery column
            if (Schema::hasColumn('events', 'gallery')) {
                $table->dropColumn('gallery');
            }
        });
    }
};