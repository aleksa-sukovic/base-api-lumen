<?php

namespace Aleksa\Library\Exceptions;

use Aleksa\Library\Exceptions\BaseException;
use Aleksa\Library\Services\Translator;

class AuthException extends BaseException
{
    public function __construct($message = null)
    {
        if (!$message) {
            $message = Translator::get('exceptions.auth.default');
        }

        parent::__construct(400, $message, 'AuthException');
    }

    public function toArray()
    {
        return [
            'status_code' => $this->getStatusCode(),
            'code'        => $this->getExceptionCode(),
            'message'     => $this->getMessage(),
            'data'        => []
        ];
    }
}
