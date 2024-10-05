<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Channel;
use App\Models\Subscription;
use App\Models\User;
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

        Channel::factory()->create([
            'user_id' => $user1->id
        ]);
        Channel::factory()->create([
            'user_id' => $user2->id
        ]);

        $users = User::all();
        $channels = Channel::all();

        Subscription::factory(500)->create([
            'user_id' => $users->random()->id,
            'channel_id' => $channels->random()->id
        ]);
    }
}
