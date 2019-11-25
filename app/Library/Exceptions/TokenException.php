<?php

namespace Aleksa\Library\Exceptions;

use Aleksa\Library\Exceptions\BaseException;
use Aleksa\Library\Services\Translator;

class TokenException extends BaseException
{
    public function __construct($message = null, $statusCode = 403)
    {
        if (!$message) {
            $message = Translator::get('exceptions.token.default');
        }

        parent::__construct($statusCode, $message, 'TokenException');
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
