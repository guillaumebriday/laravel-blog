<?php

namespace App\Scopes;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user() ?? Auth::guard('api')->user();

        // if not connected or if connected but not admin
        if (!$user || !$user->isAdmin()) {
            $builder->where('posted_at', '<=', Carbon::now());
        }
    }
}
