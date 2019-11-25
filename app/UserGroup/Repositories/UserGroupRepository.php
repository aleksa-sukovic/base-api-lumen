<?php

namespace Aleksa\UserGroup\Repositories;

use Aleksa\UserGroup\Models\UserGroup;
use Aleksa\UserGroup\Validators\UserGroupValidator;
use Aleksa\Library\Repositories\ObjectRepository;
use Aleksa\UserGroup\Processors\UserGroupQueryProcessor;

class UserGroupRepository extends ObjectRepository
{
    protected $saveEvent = 'Aleksa\UserGroup\Events\UserGroupSaved';
    protected $deleteEvent = 'Aleksa\UserGroup\Events\UserGroupDeleted';

    public function __construct(UserGroup $model, UserGroupValidator $validator, UserGroupQueryProcessor $queryProcessor)
    {
        $this->model = $model;
        $this->validator = $validator;
        $this->queryProcessor = $queryProcessor;
    }
}
