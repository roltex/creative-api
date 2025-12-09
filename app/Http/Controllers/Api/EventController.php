<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        // Status filtering
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Featured filtering
        if ($request->has('featured')) {
            $query->where('is_featured', true);
        }

        // Date range filtering
        if ($request->has('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->where('start_date', '<=', $request->date_to);
        }

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title->ka', 'like', "%{$search}%")
                  ->orWhere('title->en', 'like', "%{$search}%")
                  ->orWhere('description->ka', 'like', "%{$search}%")
                  ->orWhere('description->en', 'like', "%{$search}%")
                  ->orWhere('location->ka', 'like', "%{$search}%")
                  ->orWhere('location->en', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'start_date');
        $sortOrder = $request->get('sort_order', 'asc');
        
        if (in_array($sortBy, ['start_date', 'end_date', 'created_at', 'title'])) {
            if ($sortBy === 'title') {
                $query->orderByRaw('JSON_EXTRACT(title, "$.ka") ' . $sortOrder);
            } else {
                $query->orderBy($sortBy, $sortOrder);
            }
        }

        $perPage = $request->get('per_page', 12);
        $events = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => collect($events->items())->map(function($event) {
                return $this->transformEvent($event);
            })->values()->all(),
            'meta' => [
                'current_page' => $events->currentPage(),
                'total' => $events->total(),
                'per_page' => $events->perPage(),
                'last_page' => $events->lastPage(),
                'statuses' => $this->getStatuses()
            ]
        ]);
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        // Get related events
        $relatedEvents = $this->getRelatedEvents($event, 3);

        return response()->json([
            'success' => true,
            'data' => $this->transformEvent($event),
            'related' => $relatedEvents->map(function($relatedEvent) {
                return $this->transformEvent($relatedEvent);
            })
        ]);
    }

    public function getUpcoming(Request $request)
    {
        $limit = $request->get('limit', 6);
        
        $events = Event::where('status', 'upcoming')
            ->where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $events->map(function($event) {
                return $this->transformEvent($event);
            })
        ]);
    }

    public function getOngoing(Request $request)
    {
        $limit = $request->get('limit', 6);
        
        $events = Event::where('status', 'ongoing')
            ->orderBy('start_date', 'asc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $events->map(function($event) {
                return $this->transformEvent($event);
            })
        ]);
    }

    public function getFeatured(Request $request)
    {
        $limit = $request->get('limit', 6);
        
        $events = Event::where('is_featured', true)
            ->orderBy('start_date', 'asc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $events->map(function($event) {
                return $this->transformEvent($event);
            })
        ]);
    }

    public function getCalendar(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));
        
        $query = Event::query();
        
        if ($month && $year) {
            $query->whereYear('start_date', $year)
                  ->whereMonth('start_date', $month);
        }
        
        $events = $query->orderBy('start_date', 'asc')
            ->get()
            ->map(function($event) {
                return $this->transformEvent($event);
            });

        return response()->json([
            'success' => true,
            'data' => $events,
            'meta' => [
                'month' => $month,
                'year' => $year
            ]
        ]);
    }

    private function getRelatedEvents($event, $limit = 3)
    {
        $query = Event::where('id', '!=', $event->id);

        // Find events with similar dates or status
        if ($event->status) {
            $query->where('status', $event->status);
        }

        return $query->orderBy('start_date', 'asc')
            ->limit($limit)
            ->get();
    }

    private function getStatuses()
    {
        return ['upcoming', 'ongoing', 'completed', 'cancelled'];
    }

    /**
     * Transform event translatable fields to objects with ka/en keys
     * And snake_case to camelCase for frontend
     */
    private function transformEvent($event)
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
        
        $eventArray = $event->toArray();
        
        $rawTitle = $event->getAttributes()['title'] ?? null;
        $rawDescription = $event->getAttributes()['description'] ?? null;
        $rawLocation = $event->getAttributes()['location'] ?? null;
        
        if ($rawTitle) {
            $eventArray['title'] = $parseTranslatable($rawTitle);
        }
        if ($rawDescription) {
            $eventArray['description'] = $parseTranslatable($rawDescription);
        }
        if ($rawLocation) {
            $translatableLocation = $parseTranslatable($rawLocation);
            $eventArray['location_translatable'] = $translatableLocation;
            $eventArray['location'] = $translatableLocation['ka'] ?: $translatableLocation['en'];
        }
        
        $eventArray['startAt'] = $eventArray['start_date'] ?? null;
        $eventArray['endAt'] = $eventArray['end_date'] ?? null;
        $eventArray['isFeatured'] = $eventArray['is_featured'] ?? false;
        $eventArray['createdAt'] = $eventArray['created_at'] ?? null;
        $eventArray['updatedAt'] = $eventArray['updated_at'] ?? null;
        
        return $eventArray;
    }
}
