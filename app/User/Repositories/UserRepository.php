<?php

namespace Aleksa\User\Repositories;

use Aleksa\User\Models\User;
use Aleksa\User\Validators\UserValidator;
use Aleksa\Library\Repositories\ObjectRepository;
use Aleksa\User\Processors\UserQueryProcessor;

class UserRepository extends ObjectRepository
{
    public function __construct(User $model, UserValidator $validator, UserQueryProcessor $queryProcessor)
    {
        $this->model          = $model;
        $this->validator      = $validator;
        $this->queryProcessor = $queryProcessor;
    }
}
