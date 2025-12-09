<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SuccessStory;
use Illuminate\Http\Request;

class SuccessStoryController extends Controller
{
    public function index(Request $request)
    {
        $query = SuccessStory::orderBy('order')->orderBy('created_at', 'desc');

        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $perPage = $request->get('per_page', 12);
        $stories = $query->paginate($perPage);

        $transformedStories = collect($stories->items())->map(function($story) {
            return $this->transformSuccessStory($story);
        })->toArray();

        return response()->json([
            'success' => true,
            'data' => $transformedStories,
            'meta' => [
                'current_page' => $stories->currentPage(),
                'total' => $stories->total(),
                'per_page' => $stories->perPage(),
                'last_page' => $stories->lastPage(),
            ]
        ]);
    }

    public function show($slug)
    {
        $story = SuccessStory::where('slug', $slug)->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $this->transformSuccessStory($story)
        ]);
    }

    /**
     * Transform success story translatable fields to objects with ka/en keys
     */
    private function transformSuccessStory($story)
    {
        $parseTranslatable = function ($rawValue) {
            if (empty($rawValue)) {
                return ['ka' => '', 'en' => ''];
            }
            
            // Get raw attribute value
            $raw = is_object($rawValue) ? $rawValue : $rawValue;
            
            // If it's already an array with ka/en keys, return as is
            if (is_array($raw) && (isset($raw['ka']) || isset($raw['en']))) {
                return [
                    'ka' => $raw['ka'] ?? $raw['ge'] ?? '',
                    'en' => $raw['en'] ?? ''
                ];
            }
            
            // Try to decode JSON if it's a string
            $decoded = is_string($raw) ? json_decode($raw, true) : $raw;
            
            // If it's an array (decoded JSON), extract ka and en
            if (is_array($decoded)) {
                // Handle double-encoded JSON
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
            
            // If it's a plain string, use it for both locales
            return [
                'ka' => is_string($raw) ? $raw : '',
                'en' => is_string($raw) ? $raw : ''
            ];
        };
        
        $storyArray = $story->toArray();
        
        // Get raw attributes for translatable fields
        $rawTitle = $story->getAttributes()['title'] ?? null;
        $rawDescription = $story->getAttributes()['description'] ?? null;
        $rawStory = $story->getAttributes()['story'] ?? null;
        
        // Transform translatable fields
        if ($rawTitle) {
            $storyArray['title'] = $parseTranslatable($rawTitle);
            // Also add as 'name' for frontend compatibility
            $storyArray['name'] = $parseTranslatable($rawTitle);
        }
        if ($rawDescription) {
            $storyArray['description'] = $parseTranslatable($rawDescription);
        }
        if ($rawStory) {
            $storyArray['story'] = $parseTranslatable($rawStory);
            // Also add as 'full_description' for frontend compatibility
            $storyArray['full_description'] = $parseTranslatable($rawStory);
        }
        
        // Handle competition_name (might not be translatable)
        if (isset($storyArray['competition_name'])) {
            // If it's a string, keep it as is, otherwise transform
            if (is_string($storyArray['competition_name'])) {
                $storyArray['competition'] = $storyArray['competition_name'];
            } else {
                $storyArray['competition'] = $parseTranslatable($storyArray['competition_name']);
            }
        }
        
        // Transform achievements array if it exists
        if (isset($storyArray['achievements']) && is_array($storyArray['achievements'])) {
            $storyArray['achievements'] = array_map(function($achievement) use ($parseTranslatable) {
                if (is_string($achievement)) {
                    return $parseTranslatable($achievement);
                }
                return $achievement;
            }, $storyArray['achievements']);
        }
        
        return $storyArray;
    }
}
