<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Channel extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public function User(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function Subscriptions(): HasMany {
        return $this->hasMany(Subscription::class);
    }

    // Method to get the count of subscriptions
    public function getSubscriptionCount()
    {
        return $this->subscriptions()->count();
    }

    // chack if user is scubscribed
    public function isSubscribed() {
        if(Auth::check()) {
            return $this->subscriptions()->where('user_id', auth()->user()->id)->first();
        }
        return false;
    }

    // return media(image) of channel (if exists)
    public function image() {
        if($this->media->first()) {
            return $this->media->first()->getFullUrl('thumb');
        }

        return null;
    }

    // function to convert media(photo) to appropriate size
    public function registerMediaConversions(?Media $media = null): void {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150);
    }
}
