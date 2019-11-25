<?php

namespace Aleksa\UserGroup\Controllers;

use Aleksa\Library\Controllers\ObjectController;
use Aleksa\UserGroup\Repositories\UserGroupRepository;
use Aleksa\UserGroup\Transformers\UserGroupTransformer;

class UserGroupController extends ObjectController
{
    public function __construct(UserGroupRepository $repository, UserGroupTransformer $transformer)
    {
        $this->repository = $repository;
        $this->transformer = $transformer;
        parent::__construct();
    }
}
