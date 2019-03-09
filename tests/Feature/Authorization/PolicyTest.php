<?php

namespace Tests\Feature\Authorization;

use Tests\TestCase;
use Aleksa\UserGroup\Models\UserGroup;
use Aleksa\User\Models\User;
use Aleksa\Library\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Tests\Helpers\Traits\EnvironmentSeeds;

class PolicyTest extends TestCase
{
    use EnvironmentSeeds;

    /**
     * @var UserController
     */
    protected $controller;

    public function setUp(): void
    {
        parent::setUp();

        app()->bind('Aleksa\User\Policies\UserPolicy', function () {
            return new MockUserPolicy;
        });

        $this->seedUserGroups();
        $this->controller = app('Aleksa\User\Controllers\UserController');
    }

    public function test_authorization_succeeds_for_admin()
    {
        $this->actAsSuperAdmin();

        $this->controller->index();

        $this->expectNotToPerformAssertions();
    }

    public function test_authorization_succeeds_for_admin_privileges()
    {
        $this->actAsAdmin();

        $this->controller->index();

        $this->expectNotToPerformAssertions();
    }

    public function test_authorization_fails_for_editor()
    {
        $this->actAsEditor();

        $this->expectException(AuthorizationException::class);

        $this->controller->index();
    }

    public function test_update_works_for_owning_model()
    {
        $this->actAsUser();

        $this->controller->update(1);

        $this->expectNotToPerformAssertions();
    }

    public function test_update_fails_for_unauthorized()
    {
        $this->actAsUser();

        $targetUser = factory(User::class)->create();

        $this->expectException(AuthorizationException::class);

        $this->controller->update(2);
    }

    public function test_destroy_works_for_owning_model()
    {
        $this->actAsUser();

        $this->controller->destroy(1);

        $this->expectNotToPerformAssertions();
    }

    public function test_destroy_fails_for_unauthorized()
    {
        $this->actAsUser();
        $targetUser = factory(User::class)->create();

        $this->expectException(AuthorizationException::class);

        $this->controller->destroy(2);
    }
}
