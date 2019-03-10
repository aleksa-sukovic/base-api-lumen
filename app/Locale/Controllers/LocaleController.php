<?php

namespace Aleksa\Locale\Controllers;

use Aleksa\Locale\Transformers\LocaleTransformer;
use Aleksa\Library\Controllers\ObjectTranslationController;
use Aleksa\Locale\Repositories\LocaleRepository;

class LocaleController extends ObjectTranslationController
{
    public function __construct(LocaleRepository $repository, LocaleTransformer $transformer)
    {
        $this->repository = $repository;
        $this->transformer = $transformer;
        parent::__construct();
    }
}
