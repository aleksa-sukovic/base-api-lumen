<?php

namespace Aleksa\Library\Services;

use Illuminate\Http\Request;
use Aleksa\User\Models\User;

class AuthFacadeService
{
    /**
     * @var User
     */
    protected $user;

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function isLoggedIn(): bool
    {
        return $this->user != null;
    }
}
