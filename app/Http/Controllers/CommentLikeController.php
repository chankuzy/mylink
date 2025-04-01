<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentLikeController extends Controller
{
    public function toggle(Comment $comment)
    {
        $user = Auth::user();
        
        if ($comment->isLikedBy($user)) {
            $comment->likes()->where('user_id', $user->id)->delete();
            $action = 'unliked';
        } else {
            $comment->likes()->create(['user_id' => $user->id]);
            $action = 'liked';
        }

        return response()->json([
            'success' => true,
            'likes_count' => $comment->fresh()->likes_count,
            'is_liked' => $action === 'liked'
        ]);
    }
}