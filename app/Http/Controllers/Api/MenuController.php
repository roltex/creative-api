<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with(['items' => function ($query) {
            $query->whereNull('parent_id')
                  ->with(['children' => function ($childQuery) {
                      $childQuery->orderBy('order');
                  }])
                  ->orderBy('order');
        }])->get();

        return response()->json([
            'success' => true,
            'data' => $menus
        ]);
    }

    public function getByLocation($location)
    {
        $menu = Menu::where('location', $location)
            ->with(['items' => function ($query) {
                $query->whereNull('parent_id')
                      ->with(['children' => function ($childQuery) {
                          $childQuery->orderBy('order');
                      }])
                      ->orderBy('order');
            }])
            ->first();

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Menu not found for location: ' . $location
            ], 404);
        }

        // Transform menu items into a hierarchical structure
        $menuItems = $this->transformMenuItems($menu->items);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $menu->id,
                'name' => $menu->name,
                'location' => $menu->location,
                'items' => $menuItems
            ]
        ]);
    }

    public function getHeaderMenu()
    {
        return $this->getByLocation('header');
    }

    public function getFooterMenu()
    {
        return $this->getByLocation('footer');
    }

    private function transformMenuItems($items)
    {
        return $items->map(function ($item) {
            // Helper function to parse translatable field
            $parseTranslatable = function ($rawValue) {
                if (empty($rawValue)) {
                    return ['ka' => '', 'en' => ''];
                }
                
                // Try to decode JSON
                $decoded = json_decode($rawValue, true);
                
                // If it's already an array (decoded JSON), use it
                if (is_array($decoded)) {
                    // Handle double-encoded JSON (string that contains JSON)
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
                    'ka' => $rawValue,
                    'en' => $rawValue
                ];
            };
            
            // Get raw attributes
            $rawTitle = $item->getAttributes()['title'] ?? null;
            $rawSubtitle = $item->getAttributes()['subtitle'] ?? null;
            
            $title = $parseTranslatable($rawTitle);
            $subtitle = $parseTranslatable($rawSubtitle);
            
            return [
                'id' => $item->id,
                'title' => $title,
                'subtitle' => $subtitle,
                'url' => $item->url,
                'target' => $item->target,
                'icon' => $item->icon,
                'order' => $item->order,
                'is_active' => $item->is_active,
                'children' => $item->children ? $this->transformMenuItems($item->children) : []
            ];
        });
    }

    public function generateBreadcrumbs(Request $request)
    {
        $path = $request->get('path', '/');
        
        // Simple breadcrumb generation based on path
        $segments = array_filter(explode('/', $path));
        $breadcrumbs = [];
        $currentPath = '';

        foreach ($segments as $segment) {
            $currentPath .= '/' . $segment;
            
            // Try to find menu item for this path
            $menuItem = MenuItem::where('url', $currentPath)->first();
            
            if ($menuItem) {
                $breadcrumbs[] = [
                    'title' => $menuItem->title,
                    'url' => $menuItem->url
                ];
            } else {
                // Fallback to generating title from segment
                $breadcrumbs[] = [
                    'title' => [
                        'ka' => ucfirst(str_replace('-', ' ', $segment)),
                        'en' => ucfirst(str_replace('-', ' ', $segment))
                    ],
                    'url' => $currentPath
                ];
            }
        }

        return response()->json([
            'success' => true,
            'data' => $breadcrumbs
        ]);
    }
}
