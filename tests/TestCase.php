<?php

namespace Test;

use Laravel\Lumen\Testing\TestCase as Test;

class TestCase extends Test
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
}
