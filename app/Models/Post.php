<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'caption',
        'code',
        'programming_language',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
