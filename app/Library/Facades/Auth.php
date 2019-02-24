<?php

namespace Aleksa\Library\Facades;

use Illuminate\Support\Facades\Facade;

class Auth extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'Aleksa\Library\Services\AuthFacadeService';
    }
}
