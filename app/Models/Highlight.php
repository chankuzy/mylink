<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Highlight extends Model
{
    protected $fillable = ['title', 'cover_image', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stories()
    {
        return $this->hasMany(Story::class);
    }
}