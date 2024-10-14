<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $with = ['user', 'user.channel'];

    public function video(): BelongsTo {
        return $this->belongsTo(Video::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany {
        return $this->hasMany(Comment::class, 'comment_id')->whereNotNull('comment_id');
    }
}
