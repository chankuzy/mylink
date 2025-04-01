<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class StoriesController extends Controller
{
    public function show ()
    {
        return view('story.create');
    }

    public function index()
    {
        $stories = Story::with('user')
            ->whereDate('expires_at', '>', now())
            ->latest()
            ->take(10)
            ->get();

        return view('stories.index', compact('stories'));
    }

    public function create()
    {
        return view('story.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'media' => 'required|file|mimes:jpg,jpeg,png,mp4|max:10240',
            'type' => 'required|in:image,video'
        ]);

        $story = auth()->user()->stories()->create([
            'media' => $request->file('media')->store('stories', 'public'),
            'type' => $validated['type'],
            'expires_at' => now()->addHours(24)
        ]);

        return redirect()->route('home');
    }
}