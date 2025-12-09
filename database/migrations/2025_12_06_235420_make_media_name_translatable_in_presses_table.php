<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Convert existing string media_name to JSON format
        $presses = DB::table('presses')->get();
        
        foreach ($presses as $press) {
            if ($press->media_name && !json_decode($press->media_name)) {
                // Convert string to JSON with both languages
                $jsonValue = json_encode([
                    'ka' => $press->media_name,
                    'en' => $press->media_name // Keep same value for English initially
                ]);
                
                DB::table('presses')
                    ->where('id', $press->id)
                    ->update(['media_name' => $jsonValue]);
            }
        }
        
        // Change column type to JSON
        Schema::table('presses', function (Blueprint $table) {
            $table->json('media_name')->change();
        });
    }

    public function down(): void
    {
        // Convert JSON back to string (use Georgian or first available)
        $presses = DB::table('presses')->get();
        
        foreach ($presses as $press) {
            if ($press->media_name) {
                $decoded = json_decode($press->media_name, true);
                $stringValue = is_array($decoded) 
                    ? ($decoded['ka'] ?? $decoded['en'] ?? $press->media_name)
                    : $press->media_name;
                
                DB::table('presses')
                    ->where('id', $press->id)
                    ->update(['media_name' => $stringValue]);
            }
        }
        
        Schema::table('presses', function (Blueprint $table) {
            $table->string('media_name')->change();
        });
    }
};