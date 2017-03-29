<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'roles'
    ];

    /**
     * Transform an user.
     *
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'provider' => $user->provider,
            'provider_id' => $user->provider_id,
            'registered_at' => $user->registered_at->toIso8601String(),
            'comments_count' => $user->comments_count ?? $user->comments()->count(),
            'posts_count' => $user->posts_count ?? $user->posts()->count()
        ];
    }

    /**
     * Include Roles
     *
     * @param User $user
     * @return \League\Fractal\Resource\Collection
     */
    public function includeRoles(User $user)
    {
        $roles = $user->roles;

        return $this->collection($roles, new RoleTransformer, 'roles');
    }
}
