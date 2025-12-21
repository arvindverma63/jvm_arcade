<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Public Routes (Accessible by everyone)
|--------------------------------------------------------------------------
*/

// 1. The Homepage
Route::get('/', [PageController::class, 'home'])->name('home');

// 2. Authentication Pages (Must be public so people can actually log in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

    // Social Login
    Route::get('/auth/{provider}', [AuthController::class, 'redirectToProvider'])
        ->where('provider', 'github|google')
        ->name('social.redirect');

    Route::get('/auth/{provider}/callback', [AuthController::class, 'handleProviderCallback'])
        ->where('provider', 'github|google');
});

// Place this in the PUBLIC section (outside auth middleware)
Route::get('/discuss/{id}', [PageController::class, 'showPost'])->name('post.show');
/*
|--------------------------------------------------------------------------
| Protected Routes (Requires Login)
|--------------------------------------------------------------------------
| All routes inside this group check if the user is logged in.
| If not, they are redirected to the 'login' route.
|
*/

Route::middleware(['auth'])->group(function () {

    // Logout (Only logged-in users can log out)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected Pages
    Route::controller(PageController::class)->group(function () {
        Route::get('/latest', 'latest')->name('latest');
        Route::get('/tags', 'tags')->name('tags');
        Route::get('/snippets/new', 'createSnippet')->name('snippets.create');
        Route::get('/profile', 'profile')->name('profile');
        Route::get('/frameworks', 'frameworks')->name('frameworks');
    });
});
Route::middleware(['auth'])->prefix('profile')->name('profile.')->group(function () {
    // The main profile page (Settings) - moving it to /settings to be distinct
    Route::get('/settings', [PageController::class, 'profileSettings'])->name('settings');

    // The new pages
    Route::get('/', [PageController::class, 'profileOverview'])->name('overview'); // Default /profile
    Route::get('/notifications', [PageController::class, 'profileNotifications'])->name('notifications');
    Route::get('/snippets', [PageController::class, 'profileSnippets'])->name('snippets');
});
