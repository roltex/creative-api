<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function index(Request $request)
    {
        $query = SocialLink::active();

        $socialLinks = $query->get();

        return response()->json([
            'success' => true,
            'data' => $socialLinks->map(function($link) {
                return $this->transformSocialLink($link);
            })->values()->all()
        ]);
    }

    /**
     * Transform social link to frontend format
     */
    private function transformSocialLink($link)
    {
        $linkArray = $link->toArray();
        
        // Transform snake_case to camelCase for frontend compatibility
        $linkArray['isActive'] = $linkArray['is_active'] ?? false;
        $linkArray['createdAt'] = $linkArray['created_at'] ?? null;
        $linkArray['updatedAt'] = $linkArray['updated_at'] ?? null;
        
        return $linkArray;
    }
}

