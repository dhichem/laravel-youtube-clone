<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function store($id, $type, $model_type) {
        $model = $this->resolveVotableModel($id, $model_type);

        $vote = $model->votes()->where('user_id', Auth::id())->first();
        if($vote) {
            $vote->update([
                'type' => $type
            ]);

            return response()->json($vote->refresh(), 200);
        } else {
            return response()->json(
                $model->votes()->create([
                    'type' => $type,
                    'user_id' => Auth::id()
                ]),
                201
            );
        }
    }

    public function resolveVotableModel($id, $model_type) {
        if($model_type == 'video') {
            return Video::find($id);
        } else {
            return null;
        }
    }
}
