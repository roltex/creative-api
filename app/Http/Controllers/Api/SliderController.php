<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        $query = Slider::where('is_active', true);

        // Filter by location if specified
        if ($request->has('location') && $request->location !== 'all') {
            $query->where('location', $request->location);
        }

        // Filter by category if specified
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title->ka', 'like', "%{$search}%")
                  ->orWhere('title->en', 'like', "%{$search}%")
                  ->orWhere('subtitle->ka', 'like', "%{$search}%")
                  ->orWhere('subtitle->en', 'like', "%{$search}%");
            });
        }

        // Order by order field
        $query->orderBy('order', 'asc');

        $slides = $query->get();

        return response()->json([
            'success' => true,
            'data' => $slides,
            'meta' => [
                'total' => $slides->count(),
                'locations' => $this->getLocations(),
                'categories' => $this->getCategories()
            ]
        ]);
    }

    public function home()
    {
        $slides = Slider::where('is_active', true)
            ->where('location', 'home')
            ->orderBy('order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $slides
        ]);
    }

    public function getByLocation($location)
    {
        $slides = Slider::where('is_active', true)
            ->where('location', $location)
            ->orderBy('order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $slides
        ]);
    }

    public function show($id)
    {
        $slide = Slider::where('id', $id)
            ->where('is_active', true)
            ->first();

        if (!$slide) {
            return response()->json([
                'success' => false,
                'message' => 'Slide not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $slide
        ]);
    }

    private function getLocations()
    {
        return Slider::where('is_active', true)
            ->distinct()
            ->pluck('location')
            ->filter()
            ->values()
            ->toArray();
    }

    private function getCategories()
    {
        return Slider::where('is_active', true)
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values()
            ->toArray();
    }
}
