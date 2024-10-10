<?php

namespace App\Http\Controllers;

use App\Jobs\Videos\ConvertForStreaming;
use App\Models\Channel;
use App\Models\Video;
use Illuminate\Http\Request;

class UploadVideoController extends Controller
{
    public function index(Channel $channel) {
        return view('channels.upload', compact('channel'));
    }

    public function store(Channel $channel) {
        // return $channel->videos()->create([
        //     'title' => request()->title,
        //     'path' => request()->video->store("channels/{$channel->id}")
        // ]);

        if (request()->hasFile('video') && request()->file('video')->isValid()) {
            
            // Create the video entry in the database
            $video = new Video();
            $video->channel_id = $channel->id;
            $video->title = request()->title;
            $video->path = request()->file('video')->store("channels/{$channel->id}");
    
            if ($video->save()) {
                ConvertForStreaming::dispatch($video);
                return response()->json($video);
            } else {
                return response()->json(['error' => 'Video could not be saved'], 500);
            }
        } else {
            return response()->json(['error' => 'Bad request from client side'], 400);
        }
    }
}
