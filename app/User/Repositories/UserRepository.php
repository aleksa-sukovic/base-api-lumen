<?php

namespace Aleksa\User\Repositories;

use Aleksa\User\Models\User;
use Aleksa\User\Validators\UserValidator;
use Aleksa\Library\Repositories\ObjectRepository;
use Aleksa\User\Processors\UserQueryProcessor;
use Aleksa\Library\Exceptions\ItemNotFoundException;
use Aleksa\Library\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends ObjectRepository
{
    protected $saveEvent = 'Aleksa\User\Events\UserSaved';
    protected $deleteEvent = 'Aleksa\User\Events\UserDeleted';
    protected $createEvent = 'Aleksa\User\Events\UserCreated';

    public function __construct(User $model, UserValidator $validator, UserQueryProcessor $queryProcessor)
    {
        $this->model = $model;
        $this->validator = $validator;
        $this->queryProcessor = $queryProcessor;
    }

    public function findByEmail(string $email = '', $throw = true): ?User
    {
        $user = $this->model->where('email', $email)->first();

        if (!$user && $throw) {
            throw new ItemNotFoundException;
        }

        return $user;
    }

    public function findByCode(string $code = '', bool $throw = true): ?User
    {
        $user = $this->model->where('activation_code', $code)->first();

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

    public function afterSave(Model $item, array $params)
    {
        // setting activation code for new users
        if (!isset($params['id'])) {
            $item->activation_code = str_random(5);
            $item->save();
        }
    }
}
