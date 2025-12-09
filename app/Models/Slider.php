<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'subtitle', 'category'];

    protected $fillable = [
        'title', 'subtitle', 'category', 'image', 'link', 'button_text', 'order', 'is_active', 'location'
    ];

    protected $casts = [
        'order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    public function scopeLocation($query, $location = 'home')
    {
        return $query->where('location', $location);
    }
}
