<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Story;

class UserController extends Controller
{
    public function home()
    {
        $posts = Post::with(['user', 'comments.user'])
            ->latest()
            ->paginate(5);

        // Add error checking for auth
        $suggestions = [];
        if (auth()->check()) {
            $suggestions = User::where('id', '!=', auth()->id())
                ->inRandomOrder()
                ->limit(5)
                ->get();
        }

        $stories = []; 

        return view('home', compact('posts', 'suggestions', 'stories'));
    }

    public function profile()
    {
        $user = auth()->user();
        
        return view('profile', [
            'user' => $user,
            'posts' => $user->posts()->latest()->get(),
            // We'll implement these counts when we add followers system
            'followers_count' => 0,
            'following_count' => 0,
        ]);
    }
}