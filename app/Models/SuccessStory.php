<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SuccessStory extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'description', 'story'];

    protected $fillable = [
        'slug', 'title', 'description', 'story', 'achievements', 'image', 'gallery',
        'category', 'competition_name', 'year', 'amount', 'creator_name', 'is_featured', 'order'
    ];

    protected $casts = [
        'achievements' => 'array',
        'gallery' => 'array',
        'year' => 'integer',
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
