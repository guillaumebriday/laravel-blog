<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Role;

class RoleTransformer extends TransformerAbstract
{
    /**
     * Transform a role.
     *
     * @param Role $role
     * @return array
     */
    public function transform(Role $role)
    {
        return [
            'id' => $role->id,
            'name' => $role->name
        ];
    }
}
