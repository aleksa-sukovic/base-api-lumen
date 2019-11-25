<?php

namespace Aleksa\Locale\Translation\Validators;

use Aleksa\Library\Validators\BaseValidator;

class LocaleTranslationValidator extends BaseValidator
{
    protected $rules = [
        'name'    => 'required|string'
    ];

    protected $updateRules = [
        'name' => 'string'
    ];
}
