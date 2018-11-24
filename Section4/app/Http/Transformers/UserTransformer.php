<?php

namespace App\Http\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public $availableIncludes = [
        'roles',
    ];

    public $defaultIncludes = [
        'roles',
    ];

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
    }

    public function includeRoles(User $user) {
        return $this->collection($user->roles, new RoleTransformer());
    }
}
