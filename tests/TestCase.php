<?php

namespace Tests;

use Laravel\Lumen\Testing\TestCase as Test;
use Laravel\Lumen\Testing\DatabaseMigrations;

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
}
