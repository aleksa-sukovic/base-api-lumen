<?php

namespace Tests\Helpers\Traits;

use Aleksa\UserGroup\Models\UserGroup;

trait EnvironmentSeeds
{
    private function seedUserGroups()
    {
        factory(UserGroup::class)->create(['id' => 1, 'name' => 'super-admin']);
        factory(UserGroup::class)->create(['id' => 2, 'name' => 'admin']);
        factory(UserGroup::class)->create(['id' => 3, 'name' => 'editor']);
        factory(UserGroup::class)->create(['id' => 4, 'name' => 'user']);
    }
}
