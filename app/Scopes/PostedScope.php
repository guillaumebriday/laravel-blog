<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class PostedScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $user = Auth::user() ?? Auth::guard('sanctum')->user();

        // if not connected or if connected but not admin
        if (!$user || !$user->isAdmin()) {
            $builder->where('posted_at', '<=', now());
        }
    }
}
