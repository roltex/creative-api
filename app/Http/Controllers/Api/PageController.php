<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::where('status', 'published')
            ->orderBy('order')
            ->get()
            ->map(function($page) {
                return $this->transformPage($page);
            });

        return response()->json([
            'success' => true,
            'data' => $pages
        ]);
    }

    public function show($slug)
    {
        // Handle nested slugs like 'about/mission'
        $page = Page::where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if (!$page) {
            return response()->json([
                'success' => false,
                'message' => 'Page not found'
            ], 404);
        }

        // Transform translatable fields
        $transformedPage = $this->transformPage($page);

        return response()->json([
            'success' => true,
            'data' => $transformedPage
        ]);
    }

    public function getByTemplate($template)
    {
        $pages = Page::where('template', $template)
            ->where('status', 'published')
            ->orderBy('order')
            ->get()
            ->map(function($page) {
                return $this->transformPage($page);
            });

        return response()->json([
            'success' => true,
            'data' => $pages
        ]);
    }

    public function homepage()
    {
        $page = Page::where('is_homepage', true)
            ->where('status', 'published')
            ->first();

        if (!$page) {
            return response()->json([
                'success' => false,
                'message' => 'Homepage not found'
            ], 404);
        }

        // Transform translatable fields
        $transformedPage = $this->transformPage($page);

        return response()->json([
            'success' => true,
            'data' => $transformedPage
        ]);
    }

    /**
     * Transform page translatable fields to objects with ka/en keys
     */
    private function transformPage($page)
    {
        $translatableFields = [
            'title', 'subtitle', 'content', 'meta_title', 'meta_description',
            'hero_subtitle', 'mission_title', 'mission_content', 'mission_content_2',
            'goals_title', 'goals_content', 'values_title', 'stats_title',
            'annual_reports_title', 'strategic_plans_title', 'financial_reports_title',
            'achievements_title', 'legal_acts_title', 'regulations_title',
            'additional_info_title', 'additional_info_content', 'additional_info_button_text',
            'contact_form_title', 'contact_info_title', 'contact_address',
            'office_hours_title', 'office_hours_text', 'social_media_title', 'map_title'
        ];

        $pageArray = $page->toArray();
        
        // Transform each translatable field
        foreach ($translatableFields as $field) {
            if (isset($pageArray[$field])) {
                $pageArray[$field] = $this->parseTranslatable($pageArray[$field]);
            }
        }

        // Transform array fields that contain translatable content
        if (isset($pageArray['goals_list']) && is_array($pageArray['goals_list'])) {
            $pageArray['goals_list'] = array_map(function($item) {
                if (is_array($item) && isset($item['ka']) && isset($item['en'])) {
                    return $item; // Already transformed
                }
                return $this->parseTranslatable($item);
            }, $pageArray['goals_list']);
        }

        if (isset($pageArray['values_list']) && is_array($pageArray['values_list'])) {
            $pageArray['values_list'] = array_map(function($item) {
                if (is_array($item)) {
                    $transformed = [];
                    
                    // Handle title_ka/title_en format
                    if (isset($item['title_ka']) || isset($item['title_en'])) {
                        $transformed['ka'] = $item['title_ka'] ?? '';
                        $transformed['en'] = $item['title_en'] ?? '';
                    } 
                    // Handle ka/en format
                    else if (isset($item['ka']) || isset($item['en'])) {
                        $transformed = $this->parseTranslatable($item);
                    } else {
                        $transformed = $item;
                    }
                    
                    // Handle description_ka/description_en format
                    if (isset($item['description_ka']) || isset($item['description_en'])) {
                        $transformed['description'] = [
                            'ka' => $item['description_ka'] ?? '',
                            'en' => $item['description_en'] ?? ''
                        ];
                    } else if (isset($item['description'])) {
                        $transformed['description'] = $this->parseTranslatable($item['description']);
                    }
                    
                    // Preserve other fields like icon
                    if (isset($item['icon'])) {
                        $transformed['icon'] = $item['icon'];
                    }
                    
                    return $transformed;
                }
                return $item;
            }, $pageArray['values_list']);
        }

        if (isset($pageArray['stats_list']) && is_array($pageArray['stats_list'])) {
            $pageArray['stats_list'] = array_map(function($item) {
                if (is_array($item)) {
                    // Handle label_ka/label_en format
                    if (isset($item['label_ka']) || isset($item['label_en'])) {
                        $item['label'] = [
                            'ka' => $item['label_ka'] ?? '',
                            'en' => $item['label_en'] ?? ''
                        ];
                        unset($item['label_ka'], $item['label_en']);
                    } 
                    // Handle label object format
                    else if (isset($item['label'])) {
                        $item['label'] = $this->parseTranslatable($item['label']);
                    }
                    
                    // Preserve other fields like number, icon, suffix
                    return $item;
                }
                return $item;
            }, $pageArray['stats_list']);
        }

        // Transform reports page arrays (annual_reports_list, strategic_plans_list, financial_reports_list)
        $reportsArrays = ['annual_reports_list', 'strategic_plans_list', 'financial_reports_list'];
        foreach ($reportsArrays as $arrayKey) {
            if (isset($pageArray[$arrayKey]) && is_array($pageArray[$arrayKey])) {
                $pageArray[$arrayKey] = array_map(function($item) {
                    if (is_array($item)) {
                        // Handle title_ka/title_en format
                        if (isset($item['title_ka']) || isset($item['title_en'])) {
                            $item['title'] = [
                                'ka' => $item['title_ka'] ?? '',
                                'en' => $item['title_en'] ?? ''
                            ];
                            unset($item['title_ka'], $item['title_en']);
                        } 
                        // Handle title object format
                        else if (isset($item['title'])) {
                            $item['title'] = $this->parseTranslatable($item['title']);
                        }
                        
                        // Handle description_ka/description_en format
                        if (isset($item['description_ka']) || isset($item['description_en'])) {
                            $item['description'] = [
                                'ka' => $item['description_ka'] ?? '',
                                'en' => $item['description_en'] ?? ''
                            ];
                            unset($item['description_ka'], $item['description_en']);
                        } 
                        // Handle description object format
                        else if (isset($item['description'])) {
                            $item['description'] = $this->parseTranslatable($item['description']);
                        }
                        
                        // Preserve other fields like year, file, icon, period, style
                        return $item;
                    }
                    return $item;
                }, $pageArray[$arrayKey]);
            }
        }

        // Transform achievements_list (uses label_ka/label_en but frontend expects title.ka/title.en)
        if (isset($pageArray['achievements_list']) && is_array($pageArray['achievements_list'])) {
            $pageArray['achievements_list'] = array_map(function($item) {
                if (is_array($item)) {
                    // Handle label_ka/label_en format - convert to title for frontend
                    if (isset($item['label_ka']) || isset($item['label_en'])) {
                        $item['title'] = [
                            'ka' => $item['label_ka'] ?? '',
                            'en' => $item['label_en'] ?? ''
                        ];
                        unset($item['label_ka'], $item['label_en']);
                    } 
                    // Handle title_ka/title_en format
                    else if (isset($item['title_ka']) || isset($item['title_en'])) {
                        $item['title'] = [
                            'ka' => $item['title_ka'] ?? '',
                            'en' => $item['title_en'] ?? ''
                        ];
                        unset($item['title_ka'], $item['title_en']);
                    }
                    // Handle title object format
                    else if (isset($item['title'])) {
                        $item['title'] = $this->parseTranslatable($item['title']);
                    }
                    
                    // Handle description_ka/description_en format
                    if (isset($item['description_ka']) || isset($item['description_en'])) {
                        $item['description'] = [
                            'ka' => $item['description_ka'] ?? '',
                            'en' => $item['description_en'] ?? ''
                        ];
                        unset($item['description_ka'], $item['description_en']);
                    } 
                    // Handle description object format
                    else if (isset($item['description'])) {
                        $item['description'] = $this->parseTranslatable($item['description']);
                    }
                    
                    // Preserve other fields like number, icon, suffix
                    return $item;
                }
                return $item;
            }, $pageArray['achievements_list']);
        }

        // Transform snake_case to camelCase for frontend compatibility
        $pageArray['createdAt'] = $pageArray['created_at'] ?? null;
        $pageArray['updatedAt'] = $pageArray['updated_at'] ?? null;
        $pageArray['isHomepage'] = $pageArray['is_homepage'] ?? false;
        
        // Contact page specific fields
        $pageArray['contactAddress'] = $pageArray['contact_address'] ?? null;
        $pageArray['contactPhone'] = $pageArray['contact_phone'] ?? null;
        $pageArray['contactEmail'] = $pageArray['contact_email'] ?? null;
        $pageArray['officeHoursTitle'] = $pageArray['office_hours_title'] ?? null;
        $pageArray['officeHoursText'] = $pageArray['office_hours_text'] ?? null;
        $pageArray['socialMediaTitle'] = $pageArray['social_media_title'] ?? null;
        $pageArray['socialMediaLinks'] = $pageArray['social_media_links'] ?? null;
        $pageArray['mapTitle'] = $pageArray['map_title'] ?? null;
        $pageArray['mapEmbedUrl'] = $pageArray['map_embed_url'] ?? null;
        $pageArray['mapLatitude'] = $pageArray['map_latitude'] ?? null;
        $pageArray['mapLongitude'] = $pageArray['map_longitude'] ?? null;
        $pageArray['mapZoom'] = $pageArray['map_zoom'] ?? null;
        $pageArray['contactFormTitle'] = $pageArray['contact_form_title'] ?? null;
        $pageArray['contactFormFields'] = $pageArray['contact_form_fields'] ?? null;
        $pageArray['contactInfoTitle'] = $pageArray['contact_info_title'] ?? null;

        return $pageArray;
    }

    /**
     * Parse translatable field value to object with ka/en keys
     */
    private function parseTranslatable($rawValue)
    {
        if (empty($rawValue)) {
            return ['ka' => '', 'en' => ''];
        }

        // If it's already an array with ka/en keys, return as is
        if (is_array($rawValue) && (isset($rawValue['ka']) || isset($rawValue['en']))) {
            return [
                'ka' => $rawValue['ka'] ?? $rawValue['ge'] ?? '',
                'en' => $rawValue['en'] ?? ''
            ];
        }

        // Try to decode JSON
        $decoded = is_string($rawValue) ? json_decode($rawValue, true) : $rawValue;

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
            'ka' => is_string($rawValue) ? $rawValue : '',
            'en' => is_string($rawValue) ? $rawValue : ''
        ];
    }
}