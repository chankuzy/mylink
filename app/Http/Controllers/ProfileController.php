<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show($username = null)
    {
        $user = $username ? User::where('username', $username)->firstOrFail() : auth()->user();
        
        $posts = $user->posts()
            ->with('user')
            ->latest()
            ->paginate(12);
            
        $stats = [
            'posts_count' => $user->posts()->count(),
            'followers_count' => $user->followers()->count(),
            'following_count' => $user->following()->count()
        ];

        $similarProfiles = User::where('id', '!=', $user->id)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        $highlights = $user->highlights()
            ->latest()
            ->get();

        return view('profile.show', compact('user', 'posts', 'stats', 'similarProfiles', 'highlights'));
    }

    public function updateCoverPhoto(Request $request)
    {
        $request->validate([
            'cover_photo' => 'required|image|max:5120'
        ]);

        $user = auth()->user();

        if ($user->cover_photo) {
            Storage::disk('public')->delete($user->cover_photo);
        }

        $path = $request->file('cover_photo')->store('covers', 'public');
        $user->cover_photo = $path;
        $user->save();

        return response()->json(['success' => true]);
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:2048'
        ]);

        $user = auth()->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
        $user->save();

        return response()->json(['success' => true]);
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:255',
        ]);

        $user = auth()->user();
        $user->update($validated);

        return redirect()->route('profile.show', $user->username)
            ->with('success', 'Profile updated successfully');
    }
}