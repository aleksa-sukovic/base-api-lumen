<?php

namespace Aleksa\User\Transformers;

use Aleksa\User\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'group'
    ];

    public function transform(User $user)
    {
        return [
            'id'         => (int)$user->id,
            'full_name'  => (string)$user->full_name,
            'email'      => (string)$user->email,
            'gender'     => (string)$user->gender,
            'group_id'   => (int)$user->group_id,
            'activated'  => (bool)$user->activated,
            'birth_date' => (string)$user->birth_date
        ];
    }

    public function includeGroup(User $user)
    {
        $groupTransformer = app('Aleksa\UserGroup\Transformers\UserGroupTransformer');
        if ($user->group) {
            return $this->item($user->group, $groupTransformer);
        }
    }
}
