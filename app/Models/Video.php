<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    // Method to get the count of views
    public function getViewsCount()
    {
        return $this->views()->count();
    }

    public function editable()
    {
        return Auth::check() && Auth::id() == $this->channel->user_id;
    }
}
