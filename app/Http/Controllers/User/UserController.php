<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostReaction;
use App\Notifications\UserActionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{

    public function dashboardPage()
    {
        $posts = Post::where('user_id', Auth::id())->latest()->get();

        // Add likes and dislikes count manually
        foreach ($posts as $post) {
            $post->likes = PostReaction::where('post_id', $post->id)->where('reaction', 1)->count();
            $post->dislikes = PostReaction::where('post_id', $post->id)->where('reaction', 0)->count();
            $post->comments = PostComment::where('post_id', $post->id)->count();
        }

        return view('User.dashboard', ['posts' => $posts]);
    }

    public function postView(string $id)
    {
        $post = Post::with('user')->where('user_id', Auth::id())->findOrFail($id);
        return view('User.postView', compact('post'));
    }


    public function postAddPage()
    {
        return view('User.createPost');
    }

    public function postStore(Request $request)
    {
        // Step 1: Validate basic inputs
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240' // 2MB max
        ]);

        $path = null;

        // Step 2: Handle image upload if it exists
        if ($request->hasFile('image')) {
            $userName = Auth::user()->username;
            $image = $request->file('image');
            $filename = uniqid() . '.webp'; // Always convert to webp
            $folder = "images/posts/{$userName}";

            // Compress and resize (convert to WebP at 70% quality)
            $compressedImage = Image::make($image)
                ->resize(1000, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize(); // Don't upscale small images
                })
                ->encode('webp', 70); // WebP format

            // Save to public storage
            Storage::disk('public')->put("{$folder}/{$filename}", $compressedImage);

            $path = "{$folder}/{$filename}";
        }

        // Step 3: Create the post
        $post = Post::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'user_id' => Auth::id(),
            'picture' => $path, // Can be null
        ]);
        Cache::flush();


        // Notify followers
        $user = Auth::user();

        foreach ($user->followers as $follower) {
            $follower->notify(new UserActionNotification([
                'message' => "{$user->name} posted: {$validated['title']}",
                'url' => route('post.page', $post->id)
            ]));
        }
        // Step 4: Redirect
        return redirect()->route('dashboard.page')->with('success', 'Post created successfully!');
    }



    public function postEditPage(string $id)
    {
        $post = Post::findOrFail($id);

        Gate::authorize('view-post', $post);

        return view('User.editPost', ['post' => $post]);
    }


    public function postEdit(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $status = Post::where('user_id', Auth::id())->findorFail($request->post_id)->update(
            [
                'title' => $validated['title'],
                'description' => $validated['description']
            ]
        );
        Cache::flush();

        if ($status) {
            return redirect()->route('dashboard.page')->with('success', 'Post updated successfully.');
        }
    }

    public function deletePost(string $id)
    {
        $post = Post::where('user_id', Auth::id())->findOrFail($id);
        $post->delete();
        Cache::flush();

        return redirect()->route('dashboard.page')->with('success', 'Post deleted successfully.');
    }

    public function viewComment($id)
    {

        // ✅ Get the post details
        $post = Post::findOrFail($id);
        Gate::authorize('view-post', $id);

        $comments = PostComment::where('post_id', $id)
            ->whereNull('parent_id')
            ->with(['user', 'repliesRecursive'])
            ->latest()
            ->get();

        // ✅ Send data to the view
        return view('User.commentView', compact('post', 'comments'));
    }

    public function deleteComment($id)
    {
        $comment = PostComment::find($id);

        if (!$comment) {
            return redirect()->back()->with('error', 'Comment not found.');
        }

        if ($comment->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this comment.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }

    public function profilePage()
    {
        return view('User.profile');
    }
}
