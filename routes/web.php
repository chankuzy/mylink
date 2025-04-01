<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoriesController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\RouteController;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginView'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registerView'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected routes
// Add these routes in your web.php
Route::middleware('auth')->group(function () {
    // Move this route to the top of the group
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/', [PostController::class, 'index'])->name('home');

    // Update the post store route to use explicit path
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    
    // Update other post routes to use consistent /posts prefix
    Route::get('/posts/create', [PostController::class, 'create'])->name('create-post');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like');
    Route::post('/posts/{post}/comment', [PostController::class, 'comment'])->name('posts.comment');
    
    // Navigation routes
    Route::get('/explore', [RouteController::class, 'explore'])->name('explore');
    Route::get('/saved', [RouteController::class, 'saved'])->name('saved');
    Route::get('/chat', [RouteController::class, 'chat'])->name('chat');
    Route::get('/notifications', [RouteController::class, 'notifications'])->name('notifications');
    Route::get('/settings', [UserController::class, 'settings'])->name('settings');
    
    // Story routes
    Route::get('/create-story', [StoriesController::class, 'show'])->name('create-story');
    
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Profile routes - consolidated
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/cover-photo', [ProfileController::class, 'updateCoverPhoto'])->name('profile.cover-photo');
        Route::post('/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
        Route::get('/{username?}', [ProfileController::class, 'show'])->name('profile.show');
    });
    
    // Comment likes
    Route::post('/comments/{comment}/like', [App\Http\Controllers\CommentLikeController::class, 'toggle'])
        ->middleware('auth')
        ->name('comments.like');
    Route::post('/posts/{post}/comment', [CommentController::class, 'store']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
});