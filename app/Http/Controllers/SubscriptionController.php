<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Channel $channel)
    {
        $subscription = new Subscription();
        $subscription->user_id = auth()->id();
        $subscription->channel_id = $channel->id;

        if($subscription->save()) {
            return response()->json($subscription);
        }
        // $subscription->create([
        //     'channel_id' => $channel->id,
        //     'user_id' => auth()->id()
        // ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Channel $channel, Subscription $subscription)
    {
        $subscription->delete();
        return response()->json([]);
    }
}
