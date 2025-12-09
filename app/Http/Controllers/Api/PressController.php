<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Press;
use Illuminate\Http\Request;

class PressController extends Controller
{
    public function index(Request $request)
    {
        $query = Press::orderBy('created_at', 'desc');

        if ($request->has('media') && $request->media !== 'all') {
            $query->where(function($q) use ($request) {
                $q->where('media_name->ka', $request->media)
                  ->orWhere('media_name->en', $request->media);
            });
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('press_title->ka', 'like', "%{$search}%")
                  ->orWhere('press_title->en', 'like', "%{$search}%")
                  ->orWhere('media_name->ka', 'like', "%{$search}%")
                  ->orWhere('media_name->en', 'like', "%{$search}%");
            });
        }

        $perPage = $request->get('per_page', 12);
        $articles = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => collect($articles->items())->map(function($article) {
                return $this->transformPress($article);
            })->values()->all(),
            'meta' => [
                'current_page' => $articles->currentPage(),
                'total' => $articles->total(),
                'per_page' => $articles->perPage(),
                'last_page' => $articles->lastPage(),
            ]
        ]);
    }

    public function getMediaOutlets()
    {
        $outlets = Press::all()
            ->map(function ($press) {
                $mediaName = $press->getAttributes()['media_name'] ?? null;
                if (!$mediaName) {
                    return null;
                }
                
                $parsed = $this->parseTranslatable($mediaName);
                return $parsed['ka'] ?: $parsed['en'] ?: '';
            })
            ->filter()
            ->unique()
            ->values();

        return response()->json([
            'success' => true,
            'data' => $outlets
        ]);
    }

    /**
     * Transform press article translatable fields to objects with ka/en keys
     * And snake_case to camelCase for frontend
     */
    private function transformPress($press)
    {
        $parseTranslatable = function ($rawValue) {
            if (empty($rawValue)) {
                return ['ka' => '', 'en' => ''];
            }
            
            $raw = is_object($rawValue) ? $rawValue : $rawValue;
            
            if (is_array($raw) && (isset($raw['ka']) || isset($raw['en']))) {
                return [
                    'ka' => $raw['ka'] ?? $raw['ge'] ?? '',
                    'en' => $raw['en'] ?? ''
                ];
            }
            
            $decoded = is_string($raw) ? json_decode($raw, true) : $raw;
            
            if (is_array($decoded)) {
                if (isset($decoded['en']) && is_string($decoded['en']) && json_decode($decoded['en'], true) !== null) {
                    $innerDecoded = json_decode($decoded['en'], true);
                    return [
                        'ka' => $decoded['ka'] ?? $innerDecoded['ka'] ?? '',
                        'en' => $innerDecoded['en'] ?? ''
                    ];
                }
                return [
                    'ka' => $decoded['ka'] ?? $decoded['ge'] ?? '',
                    'en' => $decoded['en'] ?? ''
                ];
            }
            
            return [
                'ka' => is_string($raw) ? $raw : '',
                'en' => is_string($raw) ? $raw : ''
            ];
        };
        
        $pressArray = $press->toArray();
        
        // Get raw attributes for translatable fields
        $rawPressTitle = $press->getAttributes()['press_title'] ?? null;
        $rawMediaName = $press->getAttributes()['media_name'] ?? null;
        
        // Transform press_title to title
        if ($rawPressTitle) {
            $pressArray['title'] = $parseTranslatable($rawPressTitle);
        } else {
            $pressArray['title'] = ['ka' => '', 'en' => ''];
        }
        
        // Transform media_name to mediaName
        if ($rawMediaName) {
            $translatableMediaName = $parseTranslatable($rawMediaName);
            $pressArray['mediaName'] = $translatableMediaName['ka'] ?: $translatableMediaName['en'] ?: '';
        } else {
            $pressArray['mediaName'] = '';
        }
        
        // Transform snake_case to camelCase for frontend compatibility
        $pressArray['externalUrl'] = $pressArray['media_link'] ?? null;
        $pressArray['mediaLogo'] = $pressArray['media_logo'] ?? null;
        $pressArray['publishedAt'] = $pressArray['created_at'] ?? null;
        $pressArray['createdAt'] = $pressArray['created_at'] ?? null;
        $pressArray['updatedAt'] = $pressArray['updated_at'] ?? null;
        
        // Generate slug from title if not exists
        if (empty($pressArray['slug'])) {
            $title = $pressArray['title']['ka'] ?: $pressArray['title']['en'] ?: '';
            if ($title) {
                $pressArray['slug'] = \Illuminate\Support\Str::slug($title) . '-' . $pressArray['id'];
            } else {
                $pressArray['slug'] = 'press-' . $pressArray['id'];
            }
        }
        
        // Add required NewsArticle fields with defaults
        $pressArray['content'] = $pressArray['content'] ?? ['ka' => '', 'en' => ''];
        $pressArray['excerpt'] = $pressArray['excerpt'] ?? ['ka' => '', 'en' => ''];
        $pressArray['category'] = $pressArray['category'] ?? '';
        $pressArray['tags'] = $pressArray['tags'] ?? [];
        $pressArray['viewCount'] = $pressArray['view_count'] ?? 0;
        $pressArray['isFeatured'] = $pressArray['is_featured'] ?? false;
        
        return $pressArray;
    }

    /**
     * Parse translatable field helper
     */
    private function parseTranslatable($rawValue)
    {
        if (empty($rawValue)) {
            return ['ka' => '', 'en' => ''];
        }
        
        $raw = is_object($rawValue) ? $rawValue : $rawValue;
        
        if (is_array($raw) && (isset($raw['ka']) || isset($raw['en']))) {
            return [
                'ka' => $raw['ka'] ?? $raw['ge'] ?? '',
                'en' => $raw['en'] ?? ''
            ];
        }
        
        $decoded = is_string($raw) ? json_decode($raw, true) : $raw;
        
        if (is_array($decoded)) {
            if (isset($decoded['en']) && is_string($decoded['en']) && json_decode($decoded['en'], true) !== null) {
                $innerDecoded = json_decode($decoded['en'], true);
                return [
                    'ka' => $decoded['ka'] ?? $innerDecoded['ka'] ?? '',
                    'en' => $innerDecoded['en'] ?? ''
                ];
            }
            return [
                'ka' => $decoded['ka'] ?? $decoded['ge'] ?? '',
                'en' => $decoded['en'] ?? ''
            ];
        }
        
        return [
            'ka' => is_string($raw) ? $raw : '',
            'en' => is_string($raw) ? $raw : ''
        ];
    }
}