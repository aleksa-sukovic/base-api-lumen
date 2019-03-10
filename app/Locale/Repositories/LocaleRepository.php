<?php

namespace Aleksa\Locale\Repositories;

use Aleksa\Locale\Models\Locale;
use Aleksa\Locale\Validators\LocaleValidator;
use Aleksa\Locale\Processors\LocaleQueryProcessor;
use Aleksa\Library\Repositories\ObjectTranslationRepository;
use Aleksa\Locale\Translation\Repositories\LocaleTranslationRepository;

class LocaleRepository extends ObjectTranslationRepository
{
    protected $tableName = 'locales';
    protected $translationTableName = 'locale_translations';
    protected $translationForeignKey = 'locale_parent_id';
    protected $parentPrimaryKey = 'id';

    protected $saveEvent = 'Aleksa\Locale\Events\LocaleSaved';
    protected $deleteEvent = 'Aleksa\Locale\Events\LocaleDeleted';

    public function __construct(Locale $model, LocaleValidator $validator, LocaleQueryProcessor $queryProcessor, LocaleTranslationRepository $translationRepository)
    {
        $this->model = $model;
        $this->validator = $validator;
        $this->queryProcessor = $queryProcessor;
        $this->translationRepository = $translationRepository;
    }

    public function findByCode($code)
    {
        return $this->model->where('code', '=', $code)->first();
    }
}
