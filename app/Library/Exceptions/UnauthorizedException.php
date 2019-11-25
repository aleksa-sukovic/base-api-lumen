<?php

namespace Aleksa\Library\Exceptions;

use Aleksa\Library\Exceptions\BaseException;
use Aleksa\Library\Services\Translator;

class UnauthorizedException extends BaseException
{
    public function __construct($message = null)
    {
        if (!$message) {
            $message = Translator::get('exceptions.unauthorized');
        }

        parent::__construct(403, $message, 'UnauthorizedException');
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
