<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'content', 'image', 'topic_id'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function topics()
    {
        return $this->belongsTo(Topic::class);
    }
}
