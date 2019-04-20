<?php

namespace Aleksa\Library\Exceptions;

use Aleksa\Library\Exceptions\BaseException;
use Aleksa\Library\Services\Translator;

class ValidationException extends BaseException
{
    private $errors;

    public function __construct($errors)
    {
        $this->errors = $errors;
        parent::__construct(400, Translator::get('exceptions.validation'), 'ValidationException');
    }

    public function toArray()
    {
        $array = [
            'status_code' => $this->getStatusCode(),
            'code'        => $this->getExceptionCode(),
            'message'     => $this->getMessage(),
            'errors'      => $this->errors
        ];

        return $array;
    }
}
