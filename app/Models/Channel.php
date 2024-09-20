<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
