<?php

namespace App\Http\Controllers\API\public;

use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostReaction;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;   // ✅ correct



class PostController extends Controller
{

public function index(Request $request)
{
    $page = $request->get('page', 1);
    $cacheKey = "public.posts.feed.page.$page";

    $posts = Cache::remember($cacheKey, 600, function () {
        return Post::with('user')
            ->withCount([
                'reactions as likes' => fn ($q) => $q->where('reaction', 1),
                'reactions as dislikes' => fn ($q) => $q->where('reaction', 0),
            ])
            ->latest()
            ->paginate(10);
    });

    return response()->json([
        'status' => true,
        'data' => $posts
    ]);
}

   
public function latestId()
{
    $latestId = Cache::remember('posts.latest.id', 600, function () {
        // Log::info('LATEST ID DB HIT');
        return Post::max('id');
    });

    return response()->json([
        'latest_id' => $latestId
    ]);
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
