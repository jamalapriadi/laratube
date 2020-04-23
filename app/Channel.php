<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use App\User;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Channel extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        if($this->media->first())
        {
            return $this->media->first()->getFullUrl('thumb');
        }

        return null;
        
    }

    public function editable()
    {
        if(! auth()->check()) return false;

        return $this->user_id === auth()->user()->id;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->height(100);
    }

    public function subscriptions()
    {
        return $this->hasMany('\App\Subscription');
    }

    public function videos()
    {
        return $this->hasMany('App\Video');
    }
}
