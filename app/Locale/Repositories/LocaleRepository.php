<?php

namespace Aleksa\Locale\Repositories;

use Aleksa\Library\Repositories\ObjectRepository;
use Aleksa\Locale\Models\Locale;
use Aleksa\Locale\Validators\LocaleValidator;

class LocaleRepository extends ObjectRepository
{
    public function __construct(Locale $model, LocaleValidator $validator)
    {
        $this->model     = $model;
        $this->validator = $validator;
    }
}