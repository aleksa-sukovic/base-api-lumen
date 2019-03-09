<?php

namespace Aleksa\Library\Exceptions;

use Aleksa\Library\Exceptions\BaseException;
use Illuminate\Http\JsonResponse;

class RouteNotFoundException extends BaseException
{
    public function __construct($message = 'Route not found')
    {
        parent::__construct(404, $message);
    }

    public function toArray()
    {
        return [
            'status_code' => $this->getStatusCode(),
            'message'     => $this->getMessage(),
            'data'        => []
        ];
    }
}
