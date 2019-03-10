<?php

namespace Aleksa\Locale\Controllers;

use Aleksa\Locale\Transformers\LocaleTransformer;
use Aleksa\Locale\Repositories\LocaleRepository;
use Aleksa\Library\Controllers\TranslationObjectController;

class LocaleController extends TranslationObjectController
{
    public function __construct(LocaleRepository $repository, LocaleTransformer $transformer)
    {
        $this->repository = $repository;
        $this->transformer = $transformer;
        parent::__construct();
    }
}
