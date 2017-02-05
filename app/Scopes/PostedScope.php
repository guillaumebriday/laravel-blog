<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PostedScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        // if not connected or if connected but not admin
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            $builder->where('posted_at', '<=', Carbon::now());
        }
    }
}
