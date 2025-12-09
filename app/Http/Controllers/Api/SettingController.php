<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'site' => [
                'name' => [
                    'ka' => 'შემოქმედებითი საქართველო',
                    'en' => 'Creative Georgia'
                ],
                'tagline' => [
                    'ka' => 'კრეატიული ინდუსტრიების მხარდაჭერა',
                    'en' => 'Supporting Creative Industries'
                ],
                'description' => [
                    'ka' => 'შემოქმედებითი საქართველო არის ქართული კრეატიული ინდუსტრიების განვითარების მხარდამჭერი ორგანიზაცია.',
                    'en' => 'Creative Georgia is an organization supporting the development of Georgian creative industries.'
                ]
            ],
            'contact' => [
                'email' => 'info@creative-georgia.ge',
                'phone' => '+995 32 2 123 456',
                'address' => [
                    'ka' => 'თბილისი, რუსთაველის გამზირი 42',
                    'en' => '42 Rustaveli Avenue, Tbilisi, Georgia'
                ],
                'working_hours' => [
                    'ka' => 'ორშაბათი-პარასკევი: 09:00-18:00',
                    'en' => 'Monday-Friday: 09:00-18:00'
                ]
            ],
            'social' => [
                'facebook' => 'https://facebook.com/creativegeorgia',
                'instagram' => 'https://instagram.com/creativegeorgia',
                'linkedin' => 'https://linkedin.com/company/creative-georgia',
                'twitter' => 'https://twitter.com/creativegeorgia',
                'youtube' => 'https://youtube.com/creativegeorgia'
            ],
            'theme' => [
                'primary_color' => '#024243',
                'secondary_color' => '#006ea5',
                'success_color' => '#10b981',
                'warning_color' => '#f59e0b',
                'error_color' => '#ef4444'
            ],
            'features' => [
                'enable_registration' => true,
                'enable_newsletter' => true,
                'enable_file_uploads' => true,
                'max_file_size' => 10485760, // 10MB
                'allowed_file_types' => [
                    'application/pdf',
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                ]
            ],
            'statistics' => [
                'supported_projects' => 1000,
                'successful_creators' => 500,
                'total_funding' => 50000000 // in GEL cents
            ],
            'map' => [
                'latitude' => 41.6938,
                'longitude' => 44.8015,
                'zoom' => 15
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $settings
        ]);
    }

    public function getByGroup($group)
    {
        $settings = $this->index()->getData(true);
        
        if (!isset($settings['data'][$group])) {
            return response()->json([
                'success' => false,
                'message' => 'Settings group not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $settings['data'][$group]
        ]);
    }
}