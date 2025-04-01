<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        try {
            $userId = auth()->id();
            $like = Like::where('post_id', $post->id)
                       ->where('user_id', $userId)
                       ->first();

            if ($like) {
                $like->delete();
                $action = 'unliked';
                $isLiked = false;
            } else {
                Like::create([
                    'post_id' => $post->id,
                    'user_id' => $userId
                ]);
                $action = 'liked';
                $isLiked = true;
            }

            return response()->json([
                'success' => true,
                'action' => $action,
                'is_liked' => $isLiked,
                'likes_count' => $post->fresh()->likes()->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing like'
            ], 500);
        }
    }
}
