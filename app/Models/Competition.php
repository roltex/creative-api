<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Competition extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'description'];

    protected $fillable = [
        'slug',
        'title',
        'description',
        'status',
        'start_date',
        'end_date',
        'category',
        'image',
        'is_featured',
        'order',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function scopeCurrent($query)
    {
        return $query->where('status', 'current');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
