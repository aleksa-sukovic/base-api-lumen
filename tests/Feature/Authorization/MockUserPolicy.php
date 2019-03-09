<?php

namespace Tests\Feature\Authorization;

use Aleksa\User\Models\User;

class MockUserPolicy
{
    public function before(User $user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    public function index(User $user)
    {
        return $user->hasAdminPrivileges();
    }

    public function show(User $user, User $target)
    {
        return $user->hasAdminPrivileges() || $user->id === $target->id;
    }

    public function store(User $user)
    {
        return $user->hasAdminPrivileges();
    }

    public function update(User $user, User $target)
    {
        return $user->hasAdminPrivileges() || $user->id === $target->id;
    }

    public function destroy(User $user, User $target)
    {
        return $user->hasAdminPrivileges() || $user->id === $target->id;
    }
}
