<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Resource extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'description'];

    protected $fillable = [
        'title', 'description', 'file_path', 'file_type', 'file_size', 
        'category', 'url', 'download_count', 'is_active', 'order'
    ];

    protected $casts = [
        'file_size' => 'integer',
        'download_count' => 'integer',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
