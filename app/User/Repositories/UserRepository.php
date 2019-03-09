<?php

namespace Aleksa\User\Repositories;

use Aleksa\User\Models\User;
use Aleksa\User\Validators\UserValidator;
use Aleksa\Library\Repositories\ObjectRepository;
use Aleksa\User\Processors\UserQueryProcessor;
use Aleksa\Library\Exceptions\ItemNotFoundException;
use Aleksa\Library\Facades\Auth;

class UserRepository extends ObjectRepository
{
    protected $saveEvent = 'Aleksa\User\Events\UserSaved';
    protected $deleteEvent = 'Aleksa\User\Events\UserDeleted';
    protected $createdEvent = 'Aleksa\User\Events\UserCreated';

    public function __construct(User $model, UserValidator $validator, UserQueryProcessor $queryProcessor)
    {
        $this->model = $model;
        $this->validator = $validator;
        $this->queryProcessor = $queryProcessor;
    }

    public function findByEmail(string $email = '', $throw = true): User
    {
        $user = $this->model->where('email', $email)->first();

        if (!$user && $throw) {
            throw new ItemNotFoundException;
        }

        return $user;
    }

    public function processParams($params = []): array
    {
        // Only super-admins can change groups
        if (isset($params['group_id']) && (!Auth::isLoggedIn() || !Auth::getUser()->isSuperAdmin())) {
            unset($params['group_id']);
        }

        return $params;
    }
}
