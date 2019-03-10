<?php

namespace Aleksa\Locale\Policies;

use Aleksa\User\Models\User;
use Aleksa\Locale\Models\Locale;

class LocalePolicy
{
    public function before(User $user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    public function index(?User $user)
    {
        return true;
    }

    public function show(User $user, Locale $target)
    {
        return $user->hasAdminPrivileges();
    }

    public function current(?User $user)
    {
        return true;
    }

    public function store(User $user)
    {
        return $user->hasAdminPrivileges();
    }

    public function update(User $user, Locale $target)
    {
        return $user->hasAdminPrivileges();
    }

    public function destroy(User $user, User $target)
    {
        return $user->hasAdminPrivileges();
    }
}
