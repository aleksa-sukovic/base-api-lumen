<?php

namespace Aleksa\User\Transformers;

use Aleksa\User\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id'         => (int)$user->id,
            'full_name'  => (string)$user->full_name,
            'email'      => (string)$user->email,
            'gender'     => (string)$user->gender,
            'birth_date' => (string)$user->birth_date
        ];
    }
}
