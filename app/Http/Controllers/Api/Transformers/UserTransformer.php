<?php

namespace App\Http\Controllers\Api\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'name'  => $user['name'],
            'email' => $user['email'],
        ];
    }
}