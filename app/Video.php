<?php

namespace App;


class Video extends Model
{
    public function channel(){
        return $this->belongsTo('\App\Channel');
    }

    public function editable()
    {
        return auth()->check() && $this->channel->user_id == auth()->user()->id;
    }
}
