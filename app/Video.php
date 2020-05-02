<?php

namespace App;


class Video extends Model
{
    public function channel(){
        return $this->belongsTo('\App\Channel');
    }

    public function edittable()
    {
        return auth()->check() && $this->channel->user_id == auth()->user()->id;
    }

    public function votes()
    {
        return $this->morphMany('\App\Vote','voteable');
    }

    public function comments()
    {
        return $this->hasMany('\App\Comment')->whereNull('comment_id');
    }
}
