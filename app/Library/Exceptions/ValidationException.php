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
        parent::__construct(400, Translator::get('exceptions.validation'));
    }

    public function toArray()
    {
        $array = [
            'message'     => $this->getMessage(),
            'status_code' => $this->getStatusCode(),
            'errors'      => $this->errors
        ];

        return $array;
    }
}
