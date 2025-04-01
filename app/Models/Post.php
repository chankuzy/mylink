<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage; 

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'caption',
        'media',
        'media_type',
        'content',
        'location',
        'hashtags'
    ];
    protected $with = ['user', 'comments.user', 'comments.replies.user'];
    
    protected $appends = ['liked_by_user', 'likes_count', 'comments_count'];

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function getLikedByUserAttribute()
    {
        if (!auth()->check()) return false;
        return $this->likes()->where('user_id', auth()->id())->exists();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)
            ->with(['user', 'likes'])
            ->latest();
    }

    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }

    public function getImageAttribute()
    {
        return $this->media ? Storage::disk('public')->url($this->media) : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
