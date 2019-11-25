<?php

namespace Aleksa\UserGroup\Policies;

use Aleksa\User\Models\User;
use Aleksa\UserGroup\Models\UserGroup;

class UserGroupPolicy
{
    public function before(User $user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    public function index(?User $user)
    {
        return $user->hasAdminPrivileges();
    }

    public function show(User $user, UserGroup $target)
    {
        return $user->hasAdminPrivileges();
    }

    public function current(?User $user)
    {
        return $user->hasAdminPrivileges();
    }

    public function store(User $user)
    {
        return $user->hasAdminPrivileges();
    }

    public function update(User $user, UserGroup $target)
    {
        return $user->hasAdminPrivileges();
    }

    public function destroy(User $user, User $target)
    {
        return $user->hasAdminPrivileges();
    }
}
