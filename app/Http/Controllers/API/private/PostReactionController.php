<?php

namespace App\Http\Controllers\API\private;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostReaction;
use App\Notifications\UserActionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostReactionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | POST REACTION HANDLERS
    |--------------------------------------------------------------------------
    */

    // Handle like/dislike reaction
    public function react(Request $request, $post_id)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => false
            ]);
        }

        $reaction = $request->validate([
            'reaction' => 'required|in:0,1'
        ]);

        $user_id = Auth::id();

        $status = PostReaction::updateOrCreate(
            [
                'user_id' => $user_id,
                'post_id' => $post_id
            ],
            [
                'reaction' => $reaction['reaction']
            ]
        );

        // Notify post owner if liked and not self
        $post = Post::findOrFail($post_id);
        if ($post->user_id !== $user_id && $reaction['reaction'] == 1) {
            $post->user->notify(new UserActionNotification([
                'message' => Auth::user()->name . ' liked your post.',
                'url' => route('post.page', $post->id),
            ]));
        }

        if ($status) {
            return response()->json([
                'status' => true,
                'message' => 'Reaction updated',
                'data' => $reaction
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Reaction fail',
        ], 403);
    }

    // Get total likes/dislikes & user's reaction for a post
    public function getReactions($postId)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => false
            ]);
        }

        $userId = Auth::id();

        $likes = PostReaction::where('post_id', $postId)->where('reaction', 1)->count();
        $dislikes = PostReaction::where('post_id', $postId)->where('reaction', 0)->count();
        $userReaction = PostReaction::where('post_id', $postId)
            ->where('user_id', $userId)
            ->value('reaction');

        return response()->json([
            'likes' => $likes,
            'dislikes' => $dislikes,
            'userReaction' => $userReaction
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | COMMENT HANDLERS
    |--------------------------------------------------------------------------
    */

    // Save a comment to a post
    public function saveComment(Request $request)
    {

        if (!Auth::check()) {
            return response()->json([
                'status' => false
            ]);
        }

        $validated = $request->validate([
            'post_id'   => 'required|exists:posts,id',
            'comment'   => 'required|string|min:1|max:1000',
            'parent_id' => 'nullable|exists:post_comments,id' // ✅ allow replies
        ]);

        $comment = new PostComment();
        $comment->user_id   = Auth::id();
        $comment->post_id   = $validated['post_id'];
        $comment->comment   = $validated['comment'];
        $comment->parent_id = $validated['parent_id'] ?? null; // ✅ set if reply
        $comment->save();

        // ✅ Notify post owner (only if commenter is not the owner)
        $post = Post::findOrFail($validated['post_id']);
        if ($post->user_id !== Auth::id()) {
            $post->user->notify(new UserActionNotification([
                'message' => Auth::user()->name . ' commented on your post.',
                'url'     => route('post.page', $post->id),
            ]));
        }

        return response()->json([
            'status'  => true,
            'message' => 'Comment added successfully',
            'data'    => $comment
        ], 201);
    }
    // Delete comment if the user is the owner
    public function deleteComment($id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $comment = PostComment::find($id);

        if (!$comment) {
            return response()->json([
                'status' => false,
                'message' => 'Comment not found.'
            ], 404);
        }

        if ($comment->user_id !== $user->id) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized.'
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'status' => true,
            'message' => 'Comment deleted successfully.'
        ], 200);
    }
}
