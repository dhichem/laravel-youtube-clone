<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function show(Video $video) {
        if(request()->wantsJson()) {
            return response()->json($video);
        }

        return view('videos/show', compact('video'));
    }
}
