<?php

namespace Aleksa\Locale\Controllers;

use Aleksa\Library\Controllers\ObjectController;
use Aleksa\Locale\Repositories\LocaleRepository;

class LocaleController extends ObjectController
{
    public function __construct(LocaleRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }
}
