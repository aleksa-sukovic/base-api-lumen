<?php

namespace Aleksa\Library\Exceptions;

use Aleksa\Library\Exceptions\BaseException;
use Illuminate\Http\JsonResponse;
use Aleksa\Library\Services\Translator;

class MethodNotAllowedException extends BaseException
{
    public function __construct($message = null)
    {
        if (!$message) {
            $message = Translator::get('exceptions.method.not_allowed');
        }

        parent::__construct(405, $message, 'MethodNotAllowed');
    }

    public function toArray()
    {
        return  [
            'status_code' => $this->getStatusCode(),
            'code'        => $this->getExceptionCode(),
            'message'     => $this->getMessage(),
            'data'        => []
        ];
    }
}
