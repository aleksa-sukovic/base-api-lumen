<?php

namespace Aleksa\Library\Exceptions;

use Aleksa\Library\Exceptions\BaseException;
use Illuminate\Http\JsonResponse;

class ValidationException extends BaseException
{
    private $errors;

    public function __construct($errors)
    {
        $this->errors = $errors;
        parent::__construct(400, 'Validation exception');
    }

    public function toArray()
    {
        $array = [
            'message' => $this->getMessage(),
            'status_code' => $this->getStatusCode(),
            'errors' => $this->errors
        ];

        return $array;
    }
}
