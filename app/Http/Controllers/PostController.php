<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public function index()
    {
        try {
            $posts = Post::with([
                'user',
                'comments' => function($query) {
                    $query->with(['user', 'likes'])
                          ->latest();
                },
                'likes'
            ])
            ->latest()
            ->paginate(5);
            
            $suggestions = [];
            if (Auth::check()) {
                $suggestions = User::where('id', '!=', auth()->id())
                    ->inRandomOrder()
                    ->limit(10)
                    ->get();
            }
    
            $stories = [];
    
            if (request()->ajax()) {
                $html = '';
                foreach ($posts as $post) {
                    $html .= view('components.post-card', ['post' => $post])->render();
                }
                
                return response()->json([
                    'html' => $html,
                    'hasMore' => $posts->hasMorePages()
                ]);
            }
            
            return view('home', compact('posts', 'suggestions', 'stories'));
        } catch (\Exception $e) {
            \Log::error('Posts index error: ' . $e->getMessage());
            if (request()->ajax()) {
                return response()->json([
                    'error' => 'Failed to load posts'
                ], 500);
            }
            throw $e;
        }
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required_without:media',
            'media' => 'nullable'
        ]);
    
        try {
            $post = new Post();
            $post->user_id = auth()->id();
            $post->content = $request->content;
    
            if ($request->media) {
                $image_parts = explode(";base64,", $request->media);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                
                $filename = 'posts/' . uniqid() . '.' . $image_type;
                Storage::disk('public')->put($filename, $image_base64);
                
                $post->media = $filename;
            }
    
            $post->save();
            $post->load('user'); // Eager load user relationship
    
            return response()->json([
                'success' => true,
                'html' => view('components.post-card', ['post' => $post])->render(),
                'message' => 'Post created successfully!'
            ]);
    
        } catch (\Exception $e) {
            \Log::error('Post creation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating post: ' . $e->getMessage()
            ], 500);
        }
    }

    public function comment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:500'
        ]);
    
        try {
            $comment = $post->comments()->create([
                'user_id' => auth()->id(),
                'content' => $request->content
            ]);
    
            $comment->load('user');
    
            return response()->json([
                'success' => true,
                'html' => view('components.comment-card', ['comment' => $comment])->render(),
                'message' => 'Comment added successfully!'
            ]);
    
        } catch (\Exception $e) {
            \Log::error('Comment creation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error adding comment: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Post $post)
    {
        try {
            return view('posts.show', [
                'post' => $post->load('user'),
                'userComments' => $post->comments()
                    ->with('user')
                    ->latest()
                    ->get()
            ]);
        } catch (\Exception $e) {
            \Log::error('Post show error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load post.');
        }
    }
}
