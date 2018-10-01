<?php

namespace Aleksa\Locale\Controllers;

use Aleksa\Library\Controllers\ObjectController;
use Aleksa\Locale\Repositories\LocaleRepository;
use Aleksa\Locale\Transformers\LocaleTransformer;

class LocaleController extends ObjectController
{
    public function __construct(LocaleRepository $repository, LocaleTransformer $transformer)
    {
        $this->repository     = $repository;
        $this->transformer    = $transformer;
        parent::__construct();
    }
}
