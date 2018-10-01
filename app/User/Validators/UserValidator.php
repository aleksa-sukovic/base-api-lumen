<?php

namespace Aleksa\User\Validators;

use Aleksa\Library\Validators\BaseValidator;

class UserValidator extends BaseValidator
{
    protected $rules = [
        'full_name'    => 'required',
        'email'        => 'required|email',
        'birth_date'   => 'date',
        'gender'       => 'required|alpha'
    ];

    protected $updateRules = [
        'email'      => 'email',
        'birth_date' => 'date',
        'gender'     => 'alpha'
    ];
}
