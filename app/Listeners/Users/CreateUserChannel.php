<?php

namespace App\Listeners\Users;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateUserChannel
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $event->user->channel()->create([
            'name' => $event->user->name
        ]);
    }
}
