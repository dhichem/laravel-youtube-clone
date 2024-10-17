<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{
    public function updateViews(Video $video) {
        $view = new View();

        if(Auth::check()) {
            $view->user_id = Auth::id();
        } else {
            $view->ip_address = request()->ip();
        }

        $view->video_id = $video->id;
        $view->watched_at = Carbon::now();
        if($view->save()) {
            return response()->json([], 201);
        } else {
            return response()->json(['error' => 'View could not be saved'], 500);
        }
    }
}
