<?php

namespace Tests\Unit\User;

use Tests\TestCase;
use Aleksa\User\Models\User;
use Aleksa\UserGroup\Models\UserGroup;
use Tests\Helpers\Traits\EnvironmentSeeds;

class UserTest extends TestCase
{
    use EnvironmentSeeds;

    public function setUp(): void
    {
        parent::setUp();

        $this->seedUserGroups();
    }

    public function test_user_is_super_admin()
    {
        $user = factory(User::class)->state('super-admin')->make();

        $this->assertTrue($user->isSuperAdmin());
    }

    public function test_user_has_admin_privileges()
    {
        $admin = factory(User::class)->state('admin')->make();
        $superAdmin = factory(User::class)->state('super-admin')->make();
        $editor = factory(User::class)->state('editor')->make();

        $this->assertTrue($superAdmin->isSuperAdmin());
        $this->assertTrue($superAdmin->hasAdminPrivileges());
        $this->assertTrue($admin->isAdmin());
        $this->assertTrue($admin->hasAdminPrivileges());

        $this->assertFalse($editor->hasAdminPrivileges());
    }

    public function test_user_editor_privileges()
    {
        $editor = factory(User::class)->state('editor')->make();

        $this->assertTrue($editor->isEditor());
    }

    public function test_user_privileges()
    {
        $editor = factory(User::class)->state('user')->make();

        $this->assertTrue($editor->isUser());
    }
}
