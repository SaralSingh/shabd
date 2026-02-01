<?php

use App\Http\Controllers\API\private\PostReactionController;
use App\Http\Controllers\API\public\PostContoller;
use App\Http\Controllers\Pages\PageController;
use Illuminate\Support\Facades\Route;


Route::get('public/posts',[PostContoller::class,'index']);
Route::get('/all-users', [PageController::class, 'getAllUsers'])->name('users.list');
Route::get('public/post/reaction/{id}',[PostContoller::class,'getPublicReactions']);
Route::get('public/post/comment/{post_id}',[PostContoller::class,'getComments']);

Route::middleware('auth:sanctum')->group(function()
{   
    Route::post('post/comment',[PostReactionController::class,'saveComment']);
    Route::post('/posts/{post}/react',[PostReactionController::class,'react']);

    Route::get('/posts/{post}/reactions', [PostReactionController::class, 'getReactions']);
    Route::delete('post/comment/delete/{commentId}',[PostReactionController::class,'deleteComment']);
});
