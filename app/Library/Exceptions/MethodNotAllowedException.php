<?php

namespace Aleksa\Library\Exceptions;

use Aleksa\Library\Exceptions\BaseException;
use Illuminate\Http\JsonResponse;

class MethodNotAllowedException extends BaseException
{
    public function __construct($message = 'Method is not allowed')
    {
        parent::__construct(405, $message);
    }

    public function toArray()
    {
        return  [
            'status_code' => $this->getStatusCode(),
            'message'     => $this->getMessage(),
            'data'        => []
        ];
    }
}
