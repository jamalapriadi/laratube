<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Channel;
use App\Comment;
use App\Subscription;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user1= factory(User::class)->create(
            [
                'email'=>'jamal.apriadi@gmail.com'
            ]
        );

        $user2= factory(User::class)->create(
            [
                'email'=>'jaenudin@gmail.com'
            ]
        );

        $channel1= factory(Channel::class)->create(
            [
                'user_id'=>$user1->id
            ]
        );

        $channel2= factory(Channel::class)->create(
            [
                'user_id'=>$user2->id
            ]
        );

        $channel1->subscriptions()->create(
            [
                'user_id'=>$user2->id                
            ]
        );

        $channel2->subscriptions()->create(
            [
                'user_id'=>$user1->id                
            ]
        );

        factory(Subscription::class, 100)->create(
            [
                'channel_id'=>$channel1->id
            ]
        );

        factory(Subscription::class, 100)->create(
            [
                'channel_id'=>$channel2->id
            ]
        );

        // factory(Comment::class, 50)->create(
        //     [
        //         'video_id'=>'d55af980-089b-41d7-81a3-18e1c8f0e264'
        //     ]
        // );

        // $comment = Comment::first();

        // factory(Comment::class, 50)->create(
        //     [
        //         'video_id'=>'d55af980-089b-41d7-81a3-18e1c8f0e264',
        //         'comment_id'=>$comment->id
        //     ]
        // );
    }
}
