<?php

namespace App\Http\Controllers\API\public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostReaction;
use App\Http\Resources\PostResource;


class PostContoller extends Controller
{

    public function index()
    {
        $posts = Post::with('user')
            ->withCount([
                'reactions as likes' => function ($q) {
                    $q->where('reaction', 1);
                },
                'reactions as dislikes' => function ($q) {
                    $q->where('reaction', 0);
                }
            ])
            ->latest()
            ->get();

        if ($posts) {
            return response()->json([
                'status' => true,
                'message' => 'Data fetched successfully',
                'data' => ['posts' => $posts]
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data fetch failed'
            ], 403);
        }
    }


    // PostReactionController.php
    public function getPublicReactions($postId)
    {
        $likes = PostReaction::where('post_id', $postId)->where('reaction', 1)->count();
        $dislikes = PostReaction::where('post_id', $postId)->where('reaction', 0)->count();

        return response()->json([
            'status' => true,
            'likes' => $likes,
            'dislikes' => $dislikes
        ]);
    }

    public function getComments($post_id)
    {
        $comments = PostComment::where('post_id', $post_id)->with('user')->latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Fetched all comments',
            'comments' => $comments  // ✅ rename key to 'comments' to match frontend
        ], 200);
    }
}
