<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class NewsArticle extends Model
{
    use HasTranslations;

    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($model) {
            // Debug: Let's see what we have
            $georgianTitle = null;
            
            // Try to extract Georgian title from various formats
            if (is_array($model->title) && isset($model->title['ka'])) {
                $georgianTitle = $model->title['ka'];
            } elseif (is_string($model->title) && !empty($model->title)) {
                $georgianTitle = $model->title;
            } else {
                // Try to access via attribute casting
                try {
                    $titleData = $model->getTranslation('title', 'ka');
                    if (!empty($titleData)) {
                        $georgianTitle = $titleData;
                    }
                } catch (\Exception $e) {
                    // Ignore and use fallback
                }
            }
            
            // Generate slug if we have Georgian title and slug is empty
            if (!empty($georgianTitle) && empty($model->slug)) {
                $model->slug = self::generateSlugFromGeorgian($georgianTitle, $model->id);
                
                // Debug
                \Log::info('Auto-generated slug', [
                    'georgian_title' => $georgianTitle,
                    'generated_slug' => $model->slug
                ]);
            }
            
            // Final fallback if still no slug
            if (empty($model->slug)) {
                $model->slug = 'article-' . time();
                \Log::warning('Used fallback slug generation', ['model_id' => $model->id]);
            }
        });
    }

    public static function generateSlugFromGeorgian($georgianText, $id = null)
    {
        $georgianToLatin = [
            'ა' => 'a', 'ბ' => 'b', 'გ' => 'g', 'დ' => 'd', 'ე' => 'e', 'ვ' => 'v', 'ზ' => 'z',
            'თ' => 't', 'ი' => 'i', 'კ' => 'k', 'ლ' => 'l', 'მ' => 'm', 'ნ' => 'n', 'ო' => 'o',
            'პ' => 'p', 'ჟ' => 'zh', 'რ' => 'r', 'ს' => 's', 'ტ' => 't', 'უ' => 'u', 'ფ' => 'f',
            'ქ' => 'q', 'ღ' => 'gh', 'ყ' => 'y', 'შ' => 'sh', 'ჩ' => 'ch', 'ც' => 'ts', 'ძ' => 'dz',
            'წ' => 'w', 'ჭ' => 'j', 'ხ' => 'x', 'ჯ' => 'j', 'ჰ' => 'h'
        ];
        
        $latin = str_replace(array_keys($georgianToLatin), array_values($georgianToLatin), $georgianText);
        $baseSlug = Str::slug($latin);
        
        // Ensure uniqueness
        $slug = $baseSlug;
        $counter = 1;
        
        while (true) {
            $query = self::where('slug', $slug);
            if ($id) {
                $query->where('id', '!=', $id);
            }
            
            if (!$query->exists()) {
                break;
            }
            
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    public $translatable = ['title', 'content', 'excerpt'];

    protected $fillable = [
        'slug', 'title', 'content', 'excerpt', 'image', 'gallery', 'published_at', 
        'category', 'author_id', 'tags', 'view_count', 'is_featured'
    ];

    protected $casts = [
        'published_at' => 'date',
        'gallery' => 'array',
        'tags' => 'array',
        'view_count' => 'integer',
        'is_featured' => 'boolean',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
