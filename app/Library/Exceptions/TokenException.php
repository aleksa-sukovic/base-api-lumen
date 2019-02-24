<?php

namespace Aleksa\Library\Exceptions;

use Aleksa\Library\Exceptions\BaseException;

class TokenException extends BaseException
{
    public function __construct($message = 'Token Exception', $statusCode = 403)
    {
        parent::__construct($statusCode, $message);
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['data'] = [];
        return $array;
    }
}
