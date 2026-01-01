<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\AdController as AdminAdController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdClickController;
use App\Http\Controllers\AdImpressionController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return redirect('/id');
});

// Multilingual Frontend Routes
Route::get('/{locale}', [HomeController::class, 'index'])
    ->where('locale', 'id|en')
    ->name('frontend.home');

Route::get('/{locale}/article/{slug}', [FrontendController::class, 'showArticle'])
    ->where('locale', 'id|en')
    ->name('frontend.article. show');

Route::get('/{locale}/category/{slug}', [FrontendController::class, 'showCategory'])
    ->where('locale', 'id|en')
    ->name('frontend.category.show');

Route::get('/{locale}/search', [SearchController::class, 'index'])
    ->where('locale', 'id|en')
    ->name('frontend.search');

// Login redirect
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// Admin Auth Routes
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Admin Protected Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController:: class, 'index'])->name('dashboard');
    
    // Article Management
    Route::resource('articles', AdminArticleController::class);
    Route::post('articles/{id}/generate-qr', [AdminArticleController:: class, 'generateQR'])
        ->name('articles.generate-qr');
    
    // Category Management
    Route::resource('categories', AdminCategoryController:: class);
    
    // Ads Management
    Route::resource('ads', AdminAdController::class);
    Route::get('ads/stats', [AdminAdController::class, 'stats'])->name('ads.stats');
});

// Ad Tracking (Public)
Route::get('out/ad/{ad}', [AdClickController::class, 'out'])->name('ads.out');
Route::post('ads/impression/{ad}', [AdImpressionController::class, 'store'])->name('ads.impression');

// Debug route (optional - remove in production)
Route::get('{locale? }/debug-locale', function ($locale = null) {
    return [
        'app_locale' => app()->getLocale(),
        'session_app_lang' => session('app_lang'),
        'first_segment' => request()->segment(1),
        'route_locale_param' => request()->route() ? request()->route('locale') : null,
    ];
})->where('locale', 'id|en');

// Create admin user (remove in production)
Route::get('/create-admin', function () {
    if (\App\Models\User::where('email', 'admin@dmdi.com')->exists()) {
        return 'Admin user already exists! ';
    }
    
    \App\Models\User::create([
        'name' => 'Admin DMDI',
        'email' => 'admin@dmdi. com',
        'password' => bcrypt('password123'),
        'is_admin' => true
    ]);
    
    return 'Admin user created successfully!';
});