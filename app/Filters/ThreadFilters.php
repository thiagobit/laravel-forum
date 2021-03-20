<?php

namespace App\Filters;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ThreadFilters extends Filters
{
    /**
     * @var array|string[]
     */
    protected array $filters = ['by', 'popular'];

    /**
     * Filter the query by a given username.
     *
     * @param string $username
     * @return Builder
     */
    protected function by(string $username): Builder
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter the query according to most popular threads.
     *
     * @return Builder
     */
    protected function popular()
    {
        return $this->builder->reorder('replies_count', 'desc');
    }
}
