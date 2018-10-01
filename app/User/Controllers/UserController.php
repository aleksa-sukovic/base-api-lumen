<?php

namespace Aleksa\User\Controllers;

use Aleksa\Library\Controllers\ObjectController;
use Aleksa\User\Repositories\UserRepository;
use Aleksa\User\Transformers\UserTransformer;

class UserController extends ObjectController
{
    public function __construct(UserRepository $repository, UserTransformer $transformer)
    {
        $this->repository     = $repository;
        $this->transformer    = $transformer;
        parent::__construct();
    }
}
