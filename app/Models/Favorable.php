<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

trait Favorable
{
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function isFavorited(): bool
    {
        return !!$this->favorites->where('user_id', auth()->id())->count();
    }

    public function favorite(): Model|bool
    {
        $attributes = ['user_id' => auth()->id()];

        if (!$this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }

        return false;
    }

    public function favorites(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }
}
