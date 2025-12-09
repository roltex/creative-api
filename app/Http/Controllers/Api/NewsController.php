<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsArticle::orderBy('published_at', 'desc');

        // Category filtering
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Featured filtering
        if ($request->has('featured')) {
            $query->where('is_featured', true);
        }

        // Tag filtering
        if ($request->has('tag')) {
            $query->whereJsonContains('tags', $request->tag);
        }

        // Date range filtering
        if ($request->has('date_from')) {
            $query->where('published_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->where('published_at', '<=', $request->date_to);
        }

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title->ka', 'like', "%{$search}%")
                  ->orWhere('title->en', 'like', "%{$search}%")
                  ->orWhere('content->ka', 'like', "%{$search}%")
                  ->orWhere('content->en', 'like', "%{$search}%")
                  ->orWhereJsonContains('tags', $search);
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'published_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if (in_array($sortBy, ['published_at', 'view_count', 'created_at', 'title'])) {
            if ($sortBy === 'title') {
                $query->orderByRaw('JSON_EXTRACT(title, "$.ka") ' . $sortOrder);
            } else {
                $query->orderBy($sortBy, $sortOrder);
            }
        }

        $perPage = $request->get('per_page', 12);
        $articles = $query->paginate($perPage);

        $transformedArticles = collect($articles->items())->map(function($article) {
            return $this->transformNewsArticle($article);
        })->toArray();

        return response()->json([
            'success' => true,
            'data' => $transformedArticles,
            'meta' => [
                'current_page' => $articles->currentPage(),
                'total' => $articles->total(),
                'per_page' => $articles->perPage(),
                'last_page' => $articles->lastPage(),
                'categories' => $this->getCategories(),
                'tags' => $this->getTags()
            ]
        ]);
    }

    public function show($slug)
    {
        $article = NewsArticle::where('slug', $slug)->firstOrFail();
        
        // Increment view count
        $article->increment('view_count');

        // Get related articles (already transformed by getRelatedArticles)
        $relatedArticles = $this->getRelatedArticles($article, 3);

        return response()->json([
            'success' => true,
            'data' => $this->transformNewsArticle($article),
            'related' => $relatedArticles
        ]);
    }

    public function getCategories()
    {
        $categories = NewsArticle::distinct()
            ->pluck('category')
            ->filter()
            ->values()
            ->toArray();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    public function getTags()
    {
        $allTags = NewsArticle::whereNotNull('tags')
            ->pluck('tags')
            ->flatten()
            ->unique()
            ->values()
            ->toArray();

        return response()->json([
            'success' => true,
            'data' => $allTags
        ]);
    }

    public function getFeatured(Request $request)
    {
        $limit = $request->get('limit', 6);
        
        $articles = NewsArticle::where('is_featured', true)
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($article) {
                return $this->transformNewsArticle($article);
            });

        return response()->json([
            'success' => true,
            'data' => $articles
        ]);
    }

    public function getLatest(Request $request)
    {
        $limit = $request->get('limit', 6);
        
        $articles = NewsArticle::orderBy('published_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($article) {
                return $this->transformNewsArticle($article);
            });

        return response()->json([
            'success' => true,
            'data' => $articles
        ]);
    }

    public function getPopular(Request $request)
    {
        $limit = $request->get('limit', 6);
        
        $articles = NewsArticle::orderBy('view_count', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($article) {
                return $this->transformNewsArticle($article);
            });

        return response()->json([
            'success' => true,
            'data' => $articles
        ]);
    }

    private function getRelatedArticles($article, $limit = 3)
    {
        $query = NewsArticle::where('id', '!=', $article->id);

        // First, try to find articles in the same category
        if ($article->category) {
            $query->where('category', $article->category);
        }

        // If article has tags, also match by tags
        if ($article->tags && is_array($article->tags)) {
            $query->orWhere(function($q) use ($article) {
                foreach ($article->tags as $tag) {
                    $q->orWhereJsonContains('tags', $tag);
                }
            });
        }

        return $query->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($article) {
                return $this->transformNewsArticle($article);
            });
    }

    /**
     * Transform news article translatable fields to objects with ka/en keys
     */
    private function transformNewsArticle($article)
    {
        // If article is already an array (already transformed), return as is
        if (is_array($article)) {
            return $article;
        }
        
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
        
        $articleArray = $article->toArray();
        
        // Get raw attributes for translatable fields
        $rawTitle = $article->getAttributes()['title'] ?? null;
        $rawContent = $article->getAttributes()['content'] ?? null;
        $rawExcerpt = $article->getAttributes()['excerpt'] ?? null;
        
        // Transform translatable fields
        if ($rawTitle) {
            $articleArray['title'] = $parseTranslatable($rawTitle);
        }
        if ($rawContent) {
            $articleArray['content'] = $parseTranslatable($rawContent);
        }
        if ($rawExcerpt) {
            $articleArray['excerpt'] = $parseTranslatable($rawExcerpt);
        }
        
        // Transform snake_case to camelCase for frontend compatibility
        $articleArray['publishedAt'] = $articleArray['published_at'] ?? null;
        $articleArray['authorId'] = $articleArray['author_id'] ?? null;
        $articleArray['viewCount'] = $articleArray['view_count'] ?? 0;
        $articleArray['createdAt'] = $articleArray['created_at'] ?? null;
        $articleArray['updatedAt'] = $articleArray['updated_at'] ?? null;
        $articleArray['isFeatured'] = $articleArray['is_featured'] ?? false;
        
        return $articleArray;
    }

}
