<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Press extends Model
{
    use HasTranslations;

    public $translatable = ['press_title', 'media_name'];

    protected $fillable = [
        'press_title', 'media_name', 'media_link', 'media_logo'
    ];

    protected $casts = [
        // No special casts needed
    ];
}