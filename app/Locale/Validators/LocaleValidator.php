<?php

namespace Aleksa\Locale\Validators;

use Aleksa\Library\Validators\BaseValidator;

class LocaleValidator extends BaseValidator
{
    protected $rules = [
        'code'    => 'required|unique:locales,code',
        'display' => 'required'
    ];

    protected $updateRules = [
        'code' => 'unique:locales,code,{id}'
    ];
}
