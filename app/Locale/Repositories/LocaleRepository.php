<?php

namespace Aleksa\Locale\Repositories;

use Aleksa\Locale\Models\Locale;
use Aleksa\Locale\Validators\LocaleValidator;
use Aleksa\Library\Repositories\ObjectRepository;
use Aleksa\Locale\Processors\LocaleQueryProcessor;

class LocaleRepository extends ObjectRepository
{
    protected $saveEvent   = 'Aleksa\Locale\Events\LocaleSaved';
    protected $deleteEvent = 'Aleksa\Locale\Events\LocaleDeleted';

    public function __construct(Locale $model, LocaleValidator $validator, LocaleQueryProcessor $queryProcessor)
    {
        $this->model          = $model;
        $this->validator      = $validator;
        $this->queryProcessor = $queryProcessor;
    }

    public function findByCode($code)
    {
        return $this->model->where('code', '=', $code)->first();
    }
}
