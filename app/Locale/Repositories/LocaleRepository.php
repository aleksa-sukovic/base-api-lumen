<?php

namespace Aleksa\Locale\Repositories;

use Aleksa\Locale\Models\Locale;
use Aleksa\Locale\Validators\LocaleValidator;
use Aleksa\Library\Repositories\ObjectRepository;
use Aleksa\Locale\Processors\LocaleQueryProcessor;

class LocaleRepository extends ObjectRepository
{
    public function __construct(Locale $model, LocaleValidator $validator, LocaleQueryProcessor $queryProcessor)
    {
        $this->model          = $model;
        $this->validator      = $validator;
        $this->queryProcessor = $queryProcessor;
    }
}
