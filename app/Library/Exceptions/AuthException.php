<?php

namespace Aleksa\Library\Exceptions;

use Aleksa\Library\Exceptions\BaseException;

class AuthException extends BaseException
{
    public function __construct($message = 'Auth Exception')
    {
        parent::__construct(400, $message);
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
