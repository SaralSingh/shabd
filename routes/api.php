<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Pages\PageController;
use App\Http\Controllers\API\public\PostController;
use App\Http\Controllers\API\private\PostReactionController;

Route::prefix('public')->group(function () {

    // --- Posts Feed ---
    Route::post('/get-otp', [EmailController::class, 'otpSender'])->middleware('throttle:otp');
    Route::post('/verify-otp', [EmailController::class, 'verifyOtp']);
    Route::get('/post/reaction/{postId}', [PostController::class, 'getPublicReactions']);
    Route::get('/post/{postId}/comments', [PostController::class, 'getComments']);
    Route::prefix('posts')->group(function () {
        Route::get('/', [PostController::class, 'index'])
            ->middleware('throttle:60,1');   // cached but still protect

        Route::get('/latest-id', [PostController::class, 'latestId'])
            ->middleware('throttle:30,1');
    });

    // --- Public Post Data ---

    // --- Users (for search) ---
    Route::get('users', [PageController::class, 'getAllUsers'])->middleware('throttle:40,1');
});


// --- Authenticated actions ---
Route::middleware('auth:sanctum')->group(function () {

    Route::post('post/comment', [PostReactionController::class, 'saveComment']);
    Route::delete('post/comment/delete/{commentId}', [PostReactionController::class, 'deleteComment']);

    Route::post('posts/{post}/react', [PostReactionController::class, 'react']);
    Route::get('posts/{post}/reactions', [PostReactionController::class, 'getReactions']);
});
