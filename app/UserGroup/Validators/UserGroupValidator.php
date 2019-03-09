<?php

namespace Aleksa\UserGroup\Validators;

use Aleksa\Library\Validators\BaseValidator;

class UserGroupValidator extends BaseValidator
{
    protected $rules = [
        'name' => 'required|string'
    ];

    protected $updateRules = [
        'name' => 'string'
    ];
}
