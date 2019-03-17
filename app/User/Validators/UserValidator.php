<?php

namespace Aleksa\User\Validators;

use Aleksa\Library\Validators\BaseValidator;

class UserValidator extends BaseValidator
{
    protected $rules = [
        'full_name'    => 'required',
        'email'        => 'required|email|unique:users,email',
        'birth_date'   => 'date',
        'gender'       => 'alpha'
    ];

    protected $updateRules = [
        'email'      => 'email|unique:users,email,{id}',
        'birth_date' => 'date',
        'gender'     => 'alpha'
    ];
}
