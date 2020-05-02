<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function video()
    {
        return $this->belongsTo('App\Video');
    }

    public function user()
    {
        return $this->belongsTo('App\user');
    }

    public function votes()
    {
        return $this->morphMany('App\Vote','voteable');
    }

    public function replies()
    {
        return $this->hasMany('App\Comment','comment_id')->whereNotNull('comment_id');
    }
}
