<?php

namespace Tests;

use Laravel\Lumen\Testing\TestCase as Test;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Aleksa\Library\Facades\Auth;
use Aleksa\User\Models\User;

class TestCase extends Test
{
    use DatabaseMigrations;

    /**
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    public function test_working()
    {
        $this->assertTrue(true);
    }

    public function actAsSuperAdmin()
    {
        $user = factory(User::class)->state('super-admin')->create();

        Auth::setUser($user);
    }

    public function actAsAdmin()
    {
        $user = factory(User::class)->state('admin')->create();

        Auth::setUser($user);
    }

    public function actAsEditor()
    {
        $user = factory(User::class)->state('editor')->create();

        Auth::setUser($user);
    }

    public function actAsUser()
    {
        $user = factory(User::class)->state('user')->create();

        Auth::setUser($user);
    }
}
