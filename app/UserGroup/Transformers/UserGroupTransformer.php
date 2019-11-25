<?php

namespace Aleksa\UserGroup\Transformers;

use Aleksa\UserGroup\Models\UserGroup;
use League\Fractal\TransformerAbstract;

class UserGroupTransformer extends TransformerAbstract
{
    public function transform(UserGroup $userGroup)
    {
        return [
            'id'         => (int)$userGroup->id,
            'name'       => (string)$userGroup->name,
            'created_at' => (string)$userGroup->created_at,
            'updated_at' => (string)$userGroup->updated_at
        ];
    }
}
