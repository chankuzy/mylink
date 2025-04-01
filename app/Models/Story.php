<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = ['image', 'highlight_id'];

    public function highlight()
    {
        return $this->belongsTo(Highlight::class);
    }
}