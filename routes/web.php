<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SnippetController;

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

Route::middleware(['auth'])->group(function () {

    // ... existing logout and profile routes ...

    // Snippet Routes
    Route::controller(SnippetController::class)->prefix('snippets')->name('snippets.')->group(function () {
        Route::get('/new', 'create')->name('create'); // URL: /snippets/new
        Route::post('/store', 'store')->name('store'); // URL: /snippets/store
        Route::get('/{id}', 'show')->name('show');     // URL: /snippets/1
    });

    // ... other page controller routes ...
    Route::post('/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    Route::post('/like', [LikeController::class, 'toggle'])->name('like.toggle');

    Route::put('/comments/{id}', [App\Http\Controllers\CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{id}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');

    Route::post('/users/{user}/follow', [ConnectionController::class, 'toggleFollow'])->name('users.follow');
    Route::post('/users/{user}/block', [ConnectionController::class, 'toggleBlock'])->name('users.block');
    Route::get('/members', [App\Http\Controllers\MemberController::class, 'index'])->name('members.index');
    Route::get('/u/{user}', [ProfileController::class, 'show'])->name('profile.show');


    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');

    // Chat Room (using 'user' model binding)
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');

    // Send Message
    Route::post('/messages/{user}', [MessageController::class, 'store'])->name('messages.store');

    Route::put('/messages/{message}', [MessageController::class, 'update'])->name('messages.update');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
});
