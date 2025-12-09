<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompetitionController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\SuccessStoryController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\PressController;
use App\Http\Controllers\Api\SocialLinkController;
use App\Http\Controllers\Api\ApplicationController;

// Settings & Configuration
Route::get('/settings', [SettingController::class, 'index']);
Route::get('/settings/{group}', [SettingController::class, 'getByGroup']);

// Sliders
Route::get('/sliders', [SliderController::class, 'index']);
Route::get('/sliders/home', [SliderController::class, 'home']);
Route::get('/sliders/location/{location}', [SliderController::class, 'getByLocation']);
Route::get('/sliders/{id}', [SliderController::class, 'show']);

// Menus
Route::get('/menus', [\App\Http\Controllers\Api\MenuController::class, 'index']);
Route::get('/menus/header', [\App\Http\Controllers\Api\MenuController::class, 'getHeaderMenu']);
Route::get('/menus/footer', [\App\Http\Controllers\Api\MenuController::class, 'getFooterMenu']);
Route::get('/menus/location/{location}', [\App\Http\Controllers\Api\MenuController::class, 'getByLocation']);
Route::get('/menus/breadcrumbs', [\App\Http\Controllers\Api\MenuController::class, 'generateBreadcrumbs']);

// Competitions
Route::get('/competitions', [CompetitionController::class, 'index']);
Route::get('/competitions/current', [CompetitionController::class, 'getCurrent']);
Route::get('/competitions/completed', [CompetitionController::class, 'getCompleted']);
Route::get('/competitions/upcoming', [CompetitionController::class, 'getUpcoming']);
Route::get('/competitions/featured', [CompetitionController::class, 'getFeatured']);
Route::get('/competitions/categories', [CompetitionController::class, 'getCategories']);
Route::get('/competitions/statuses', [CompetitionController::class, 'getStatuses']);
Route::get('/competitions/{slug}', [CompetitionController::class, 'show']);

// News
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/featured', [NewsController::class, 'getFeatured']);
Route::get('/news/latest', [NewsController::class, 'getLatest']);
Route::get('/news/popular', [NewsController::class, 'getPopular']);
Route::get('/news/categories', [NewsController::class, 'getCategories']);
Route::get('/news/tags', [NewsController::class, 'getTags']);
Route::get('/news/{slug}', [NewsController::class, 'show']);

// Press
Route::get('/press', [PressController::class, 'index']);
Route::get('/press/media/outlets', [PressController::class, 'getMediaOutlets']);

// Events
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/upcoming', [EventController::class, 'getUpcoming']);
Route::get('/events/ongoing', [EventController::class, 'getOngoing']);
Route::get('/events/featured', [EventController::class, 'getFeatured']);
Route::get('/events/calendar', [EventController::class, 'getCalendar']);
Route::get('/events/{slug}', [EventController::class, 'show']);

// Success Stories
Route::get('/success-stories', [SuccessStoryController::class, 'index']);
Route::get('/success-stories/{slug}', [SuccessStoryController::class, 'show']);

// FAQs
Route::get('/faqs', [FaqController::class, 'index']);

// Social Links
Route::get('/social-links', [SocialLinkController::class, 'index']);

// Pages
Route::get('/pages', [PageController::class, 'index']);
Route::get('/pages/homepage', [PageController::class, 'homepage']);
Route::get('/pages/template/{template}', [PageController::class, 'getByTemplate']);
Route::get('/pages/{slug}', [PageController::class, 'show'])->where('slug', '.*');

// Authentication routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

// Applications (public submission)
Route::post('/applications', [ApplicationController::class, 'store']);
Route::get('/applications/{id}/download/word', [ApplicationController::class, 'downloadWord'])->name('api.applications.download.word');
Route::get('/applications/{id}/download/excel', [ApplicationController::class, 'downloadExcel'])->name('api.applications.download.excel');
Route::post('/applications/{id}/regenerate-documents', [ApplicationController::class, 'regenerateDocuments'])->name('api.applications.regenerate.documents');

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    });
});
