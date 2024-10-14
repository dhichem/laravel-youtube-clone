<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Channel;
use App\Models\Comment;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $user1 = User::factory()->create([
            'name' => 'john',
            'email' => 'john@gmail.com'
        ]);

        $user2 = User::factory()->create([
            'name' => 'sara',
            'email' => 'sara@gmail.com'
        ]);

        $channel_1 = Channel::factory()->create([
            'user_id' => $user1->id
        ]);

        $channel_2 = Channel::factory()->create([
            'user_id' => $user2->id
        ]);

        // $users = User::all();
        // $channels = Channel::all();

        Subscription::factory(1500)->create([
            'user_id' => $user1->id,
            'channel_id' => $channel_2->id
        ]);

        $video = Video::factory()->create([
            'channel_id' => $channel_2->id
        ]);

        Comment::factory(100)->create([
            'video_id' => $video->id,
            'user_id' => $user1->id
        ]);

        $comment = Comment::first();

        Comment::factory(30)->create([
            'video_id' => $video->id,
            'user_id' => $user1->id,
            'comment_id' => $comment->id
        ]);
    }
}
