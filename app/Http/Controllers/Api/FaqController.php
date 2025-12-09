<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $query = Faq::active();

        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $faqs = $query->get();

        return response()->json([
            'success' => true,
            'data' => $faqs->map(function($faq) {
                return $this->transformFaq($faq);
            })->values()->all()
        ]);
    }

    /**
     * Transform FAQ translatable fields to objects with ka/en keys
     * And snake_case to camelCase for frontend
     */
    private function transformFaq($faq)
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
        
        $faqArray = $faq->toArray();
        
        // Get raw attributes for translatable fields
        $rawQuestion = $faq->getAttributes()['question'] ?? null;
        $rawAnswer = $faq->getAttributes()['answer'] ?? null;
        
        // Transform translatable fields
        if ($rawQuestion) {
            $faqArray['question'] = $parseTranslatable($rawQuestion);
        } else {
            $faqArray['question'] = ['ka' => '', 'en' => ''];
        }
        
        if ($rawAnswer) {
            $faqArray['answer'] = $parseTranslatable($rawAnswer);
        } else {
            $faqArray['answer'] = ['ka' => '', 'en' => ''];
        }
        
        // Transform snake_case to camelCase for frontend compatibility
        $faqArray['createdAt'] = $faqArray['created_at'] ?? null;
        $faqArray['updatedAt'] = $faqArray['updated_at'] ?? null;
        
        // Convert id to string if it's numeric
        $faqArray['id'] = (string) $faqArray['id'];
        
        return $faqArray;
    }
}
