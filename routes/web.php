<?php

use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [\App\Http\Controllers\Public\HomeController::class, 'index'])->name('home');

// Subscribe Routes
Route::get('/subscribe', [\App\Http\Controllers\Public\SubscriberController::class, 'redirect'])->name('subscribe');
Route::get('/subscribe/{tabloidId}', [\App\Http\Controllers\Public\SubscriberController::class, 'redirectForTabloid'])->name('subscribe.redirectForTabloid');
Route::get('/auth/google/callback', [\App\Http\Controllers\Public\SubscriberController::class, 'callback'])->name('subscribe.callback');

// Pages Routes
Route::prefix('halaman')->group(function () {
    Route::get('/', [\App\Http\Controllers\Public\PageController::class, 'index'])->name('pages.index');
    Route::get('/{slug}', [\App\Http\Controllers\Public\PageController::class, 'show'])->name('pages.show');
});

// Videos Routes
Route::prefix('video')->group(function () {
    Route::get('/', [\App\Http\Controllers\Public\VideoController::class, 'index'])->name('videos.index');
    Route::get('/{slug}', [\App\Http\Controllers\Public\VideoController::class, 'show'])->name('videos.show');
});

// Tabloids Routes
Route::prefix('tabloid')->group(function () {
    Route::get('/', [\App\Http\Controllers\Public\TabloidController::class, 'index'])->name('tabloids.index');
    Route::post('/view/{id}', [\App\Http\Controllers\Public\TabloidController::class, 'incrementViewCount'])->name('tabloids.view');
});

// Filemanager Routes
Route::get('/storage/fm/{uuid}/{filename}', [\App\Http\Controllers\Public\FileManagerController::class, 'storageByUuid'])->name('filemanager.storage');
Route::get('/fm/f/{path}', [\App\Http\Controllers\Public\FileManagerController::class, 'show'])->name('filemanager.show');
Route::get('api/filemanager/v1/public-files/{id}', [\App\Http\Controllers\Public\FileManagerController::class, 'getPublicFile'])->name('filemanager.getPublicFile');

Route::prefix('jt-admin')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::livewire('/login', 'pages::auth.concerns.login')->name('jt.login');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/api/template/update', [\App\Http\Controllers\Api\TemplateController::class, 'update'])->name('template.update');

        Route::livewire('/', 'pages::dashboard')->name('dashboard');
        Route::livewire('/dashboard', 'pages::dashboard')->name('dashboard');

        // Profile
        Route::livewire('/profile', 'pages::profile.index')->name('profile');

        // System Health
        Route::livewire('/system-health', 'pages::system-health.index')->name('system-health');

        // Activity Logs
        Route::livewire('/activity-logs', 'pages::activity-logs.index')->name('activity-logs');

        // File Manager
        Route::livewire('/file-manager', 'pages::file-manager.index')->name('file-manager');

        // Settings CRUD
        Route::livewire('/settings', 'pages::settings.index')->name('settings');
        Route::livewire('/settings/create', 'pages::settings.form')->name('settings.create');
        Route::livewire('/settings/{setting}/edit', 'pages::settings.form')->name('settings.edit');

        // Users CRUD
        Route::livewire('/users', 'pages::users.index')->name('users');
        Route::livewire('/users/create', 'pages::users.form')->name('users.create');
        Route::livewire('/users/{user}/edit', 'pages::users.form')->name('users.edit');

        // Subscribers CRUD
        Route::livewire('/subscribers', 'pages::subscribers.index')->name('subscribers');

        // Pages CRUD
        Route::livewire('/pages', 'pages::pages.index')->name('pages');
        Route::livewire('/pages/create', 'pages::pages.form')->name('pages.create');
        Route::livewire('/pages/{page}/edit', 'pages::pages.form')->name('pages.edit');

        // Tabloids CRUD
        Route::livewire('/tabloids', 'pages::tabloids.index')->name('tabloids');
        Route::livewire('/tabloids/create', 'pages::tabloids.form')->name('tabloids.create');
        Route::livewire('/tabloids/{tabloid}/edit', 'pages::tabloids.form')->name('tabloids.edit');

        // Videos CRUD
        Route::livewire('/videos', 'pages::videos.index')->name('videos');
        Route::livewire('/videos/create', 'pages::videos.form')->name('videos.create');
        Route::livewire('/videos/{video}/edit', 'pages::videos.form')->name('videos.edit');

        // Headlines CRUD
        Route::livewire('headlines', 'pages::headlines.index')->name('headlines');
        Route::livewire('headlines/create', 'pages::headlines.form')->name('headlines.create');
        Route::livewire('headlines/{headline}/edit', 'pages::headlines.form')->name('headlines.edit');

        // Speeches CRUD
        Route::livewire('speeches', 'pages::speeches.index')->name('speeches');
        Route::livewire('speeches/create', 'pages::speeches.form')->name('speeches.create');
        Route::livewire('speeches/{speech}/edit', 'pages::speeches.form')->name('speeches.edit');
    });
});
