<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    use HasFactory;

    protected $with = ['user', 'user.channel'];

    protected $appends = ['repliesCount', 'upVotesCount', 'downVotesCount', 'checkIfReacted'];

    public function video(): BelongsTo {
        return $this->belongsTo(Video::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany {
        return $this->hasMany(Comment::class, 'comment_id')->whereNotNull('comment_id');
    }

    public function votes(): MorphMany {
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function getUpVotesCountAttribute() {
        return $this->votes()->where('type', 'up')->count();
    }

    public function getDownVotesCountAttribute() {
        return $this->votes()->where('type', 'down')->count();
    }

    public function getRepliesCountAttribute() {
        return $this->replies->count();
    }

    public function getCheckIfReactedAttribute()
    {
        if(Auth::check() && $this->votes()->where('user_id', Auth::id())->exists()) {
            return $this->votes()->where('user_id', Auth::id())->first();
        }
        return false;
    }
}
