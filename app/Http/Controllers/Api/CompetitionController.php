<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function index(Request $request)
    {
        $query = Competition::query();

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Filter by featured
        if ($request->has('featured')) {
            $query->where('is_featured', true);
        }

        // Date range filtering
        if ($request->has('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->where('end_date', '<=', $request->date_to);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title->ka', 'like', "%{$search}%")
                  ->orWhere('title->en', 'like', "%{$search}%")
                  ->orWhere('description->ka', 'like', "%{$search}%")
                  ->orWhere('description->en', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'order');
        $sortOrder = $request->get('sort_order', 'asc');
        
        if (in_array($sortBy, ['order', 'start_date', 'end_date', 'created_at', 'title'])) {
            if ($sortBy === 'title') {
                $query->orderByRaw('JSON_EXTRACT(title, "$.ka") ' . $sortOrder);
            } else {
                $query->orderBy($sortBy, $sortOrder);
            }
        }

        // Secondary sort
        if ($sortBy !== 'created_at') {
            $query->orderBy('created_at', 'desc');
        }

        $perPage = $request->get('per_page', 12);
        $competitions = $query->paginate($perPage);

        $transformedItems = collect($competitions->items())->map(function($competition) {
            return $this->transformCompetition($competition);
        })->toArray();

        return response()->json([
            'success' => true,
            'data' => $transformedItems,
            'meta' => [
                'current_page' => $competitions->currentPage(),
                'total' => $competitions->total(),
                'per_page' => $competitions->perPage(),
                'last_page' => $competitions->lastPage(),
                'categories' => $this->getCategories(),
                'statuses' => $this->getStatuses()
            ]
        ]);
    }

    public function show($slug)
    {
        $competition = Competition::where('slug', $slug)->firstOrFail();

        // Get related competitions
        $relatedCompetitions = $this->getRelatedCompetitions($competition, 3);

        return response()->json([
            'success' => true,
            'data' => $this->transformCompetition($competition),
            'related' => $relatedCompetitions
        ]);
    }

    public function getCurrent(Request $request)
    {
        $limit = $request->get('limit', 12);
        
        $competitions = Competition::where('status', 'current')
            ->orderBy('order')
            ->orderBy('start_date', 'asc')
            ->limit($limit)
            ->get()
            ->map(function($competition) {
                return $this->transformCompetition($competition);
            });

        return response()->json([
            'success' => true,
            'data' => $competitions
        ]);
    }

    public function getCompleted(Request $request)
    {
        $limit = $request->get('limit', 12);
        
        $competitions = Competition::where('status', 'completed')
            ->orderBy('end_date', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($competition) {
                return $this->transformCompetition($competition);
            });

        return response()->json([
            'success' => true,
            'data' => $competitions
        ]);
    }

    public function getUpcoming(Request $request)
    {
        $limit = $request->get('limit', 12);
        
        $competitions = Competition::where('status', 'upcoming')
            ->orderBy('start_date', 'asc')
            ->limit($limit)
            ->get()
            ->map(function($competition) {
                return $this->transformCompetition($competition);
            });

        return response()->json([
            'success' => true,
            'data' => $competitions
        ]);
    }

    public function getFeatured(Request $request)
    {
        $limit = $request->get('limit', 6);
        
        $competitions = Competition::where('is_featured', true)
            ->orderBy('order')
            ->limit($limit)
            ->get()
            ->map(function($competition) {
                return $this->transformCompetition($competition);
            });

        return response()->json([
            'success' => true,
            'data' => $competitions
        ]);
    }

    public function getCategories()
    {
        $categories = Competition::distinct()
            ->pluck('category')
            ->filter()
            ->values()
            ->toArray();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    public function getStatuses()
    {
        return response()->json([
            'success' => true,
            'data' => ['upcoming', 'current', 'completed', 'cancelled']
        ]);
    }

    private function getRelatedCompetitions($competition, $limit = 3)
    {
        $query = Competition::where('id', '!=', $competition->id);

        // First, try to find competitions in the same category
        if ($competition->category) {
            $query->where('category', $competition->category);
        }

        return $query->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($comp) {
                return $this->transformCompetition($comp);
            });
    }

    /**
     * Transform competition translatable fields to objects with ka/en keys
     */
    private function transformCompetition($competition)
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
        
        $competitionArray = $competition->toArray();
        
        // Get raw attributes for translatable fields
        $rawTitle = $competition->getAttributes()['title'] ?? null;
        $rawDescription = $competition->getAttributes()['description'] ?? null;
        
        // Transform translatable fields
        $competitionArray['title'] = $parseTranslatable($rawTitle);
        if ($rawDescription) {
            $competitionArray['description'] = $parseTranslatable($rawDescription);
        }
        
        return $competitionArray;
    }

}
