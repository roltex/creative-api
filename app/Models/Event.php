<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Event extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'description', 'location'];

    protected $fillable = [
        'slug', 'title', 'description', 'start_date', 'end_date', 'location', 'image',
        'gallery', 'is_featured', 'status'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'gallery' => 'array',
        'is_featured' => 'boolean',
    ];

    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
