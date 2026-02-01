<?php

namespace App\Http\Controllers\Pages;

use App\Notifications\UserActionNotification;
use App\Http\Controllers\Controller;
use App\Models\Follower;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function mainPage()
    { 
        return view('Visitor.home');
    }

        public function homePage()
    { 
        return view('pages.home');
    }
    public function getAllUsers()
    {
        $users = User::select('id', 'name', 'username', 'email')->get();
        return response()->json(['users' => $users]);
    }

    public function fetchUserPost(string $id)
    {
        $post = Post::with('user')->findOrFail($id);
        return view('pages.post', compact('post'));
    }

    public function fetchUserProfile(string $id)
    {

        $user = User::withCount(['followers', 'followings'])->with(['posts' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id); // eager load posts

        $isFollowing = false;
        if (Auth::check()) {
            $isFollowing = $user->followers->contains(Auth::id());
        }
        return view('pages.profilePage', compact('user', 'isFollowing'));
    }

    public function follow(string $id)
    {
        if (Auth::id() == $id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        // Prevent duplicate follow
        $exists = Follower::where('follower_id', Auth::id())
            ->where('following_id', $id)
            ->exists();

        if (!$exists) {
            Follower::create([
                'follower_id' => Auth::id(),
                'following_id' => $id
            ]);

            // ✅ Send Notification to the followed user
            $follower = Auth::user();
            $followedUser = User::findOrFail($id);

            $followedUser->notify(new UserActionNotification([
                'message' => "{$follower->name} started following you.",
                'url' => route('user.page', $follower->id),
            ]));
        }

        return back();
    }


    public function unfollow(string $id)
    {
        Follower::where([
            ['follower_id', '=', Auth::id()],
            ['following_id', '=', $id]
        ])->delete();
        return back();
    }
}
