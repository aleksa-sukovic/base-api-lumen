<?php

namespace Aleksa\Locale\Translation\Repositories;

use Aleksa\Library\Repositories\ObjectRepository;
use Aleksa\Locale\Translation\Models\LocaleTranslation;
use Aleksa\Locale\Translation\Validators\LocaleTranslationValidator;

class LocaleTranslationRepository extends ObjectRepository
{
    protected $saveEvent = 'Aleksa\Locale\Translation\Events\LocaleTranslationSaved';
    protected $deleteEvent = 'Aleksa\Locale\Translation\Events\LocaleTranslationDeleted';
    protected $createdEvent = 'Aleksa\Locale\Translation\Events\LocaleTranslationCreated';

    public function __construct(LocaleTranslation $model, LocaleTranslationValidator $validator)
    {
        $this->model = $model;
        $this->validator = $validator;
    }
}
