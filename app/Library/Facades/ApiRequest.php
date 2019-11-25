<?php

namespace Aleksa\Library\Facades;

use Illuminate\Support\Facades\Facade;

class ApiRequest extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'Aleksa\Library\Services\ApiRequestService';
    }
}
