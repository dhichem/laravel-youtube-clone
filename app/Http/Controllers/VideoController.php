<?php

namespace App\Http\Controllers;

use App\Http\Requests\Videos\UpdateVideoRequest;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index() {
        // $this->user();
        // return response()->json(Video::paginate());
    }

    public function show(Video $video) {
        if(request()->wantsJson()) {
            return response()->json($video);
        }

        return view('videos/show', compact('video'));
    }

    public function update(UpdateVideoRequest $request, Video $video) {
        $video->update([
            'title' => $request['title'],
            'description' => $request['description']
        ]);

        return redirect()->back();
    }
}
