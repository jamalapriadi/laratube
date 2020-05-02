<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use App\Video;
use App\User;

use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'body'=>$faker->sentence(6),
        'user_id'=>'07e55d6b-9720-4db6-a5af-3d3e27ad79fe',
        'video_id'=> 'd55af980-089b-41d7-81a3-18e1c8f0e264',
        'comment_id'=>null
    ];
});
