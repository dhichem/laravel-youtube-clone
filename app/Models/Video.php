<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

class Video extends Model
{
    use HasFactory;

    public function channel(): BelongsTo {
        return $this->belongsTo(Channel::class);
    }

    public function views(): HasMany {
        return $this->hasMany(View::class);
    }

    public function votes(): MorphMany {
        return $this->morphMany(Vote::class, 'voteable');
    }

    // Method to get the count of views
    public function getViewsCount()
    {
        return $this->views()->count();
    }

    public function getUpVotesCount()
    {
        return $this->votes()->where('type', 'up')->count();
    }

    public function getDownVotesCount()
    {
        return $this->votes()->where('type', 'down')->count();
    }

    public function checkIfReacted()
    {
        if(Auth::check() && $this->votes()->where('user_id', Auth::id())->exists()) {
            return $this->votes()->where('user_id', Auth::id())->first();
        }
        return false;
    }

    public function editable()
    {
        return Auth::check() && Auth::id() == $this->channel->user_id;
    }
}
