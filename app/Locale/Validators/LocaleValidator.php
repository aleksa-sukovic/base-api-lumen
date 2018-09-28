<?php

namespace Aleksa\Locale\Validators;

use Aleksa\Library\Validators\BaseValidator;

class LocaleValidator extends BaseValidator
{
    protected $rules = [
        'code'    => 'required',
        'display' => 'required'
    ];

    protected $updateRules = [

    ];
}
