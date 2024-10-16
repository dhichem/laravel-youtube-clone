<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(Video $video) {
        return $video->comments()->paginate(10);
    }

    public function getReplies(Comment $comment) {
        return $comment->replies()->paginate(10);
    }

    public function store(Video $video) {
        return $video->comments()->create([
            'content' => request()->content,
            'user_id' => Auth::id(),
            'comment_id' => request()->comment_id ?? null
        ])->fresh();
    }
}
