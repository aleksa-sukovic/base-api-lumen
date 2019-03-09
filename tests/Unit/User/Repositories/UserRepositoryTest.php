<?php

namespace Tests\Unit\User\Repositories;

use Tests\TestCase;
use Tests\Helpers\Traits\EnvironmentSeeds;

class UserRepositoryTest extends TestCase
{
    use EnvironmentSeeds;

    /**
     * @var UserRepository
     */
    protected $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = app('Aleksa\User\Repositories\UserRepository');
        $this->seedUserGroups();
    }

    public function test_removing_group_param_for_regular_user()
    {
        $this->actAsUser();

        $processed = $this->repository->processParams(['group_id' => 1]);

        $this->assertArrayNotHasKey('group_id', $processed);
    }

    public function test_keeping_group_param_for_super_admins()
    {
        $this->actAsSuperAdmin();

        $processed = $this->repository->processParams(['group_id' => 2]);

        $this->assertArrayHasKey('group_id', $processed);
    }
}
