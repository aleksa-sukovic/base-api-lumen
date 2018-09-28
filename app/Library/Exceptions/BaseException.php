<?php

namespace Aleksa\Library\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;

class BaseException extends Exception
{
    protected $statusCode;
    protected $withTrace;

    public function __construct($statusCode = 500, $message = '', $withTrace = true)
    {
        $this->statusCode = $statusCode;
        $this->withTrace  = $withTrace;
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return response()->json($this->toArray(), $this->getStatusCode());
    }

    public function toArray()
    {
        $data = [
            'class'       => get_class($this),
            'status_code' => $this->getStatusCode(),
            'file'        => $this->getFile(),
            'line'        => $this->getLine(),
            'message'     => $this->getMessage(),
        ];

        if ($this->withTrace) {
            $data['trace'] = $this->getTrace();
        }

        return $data;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function isWithTrace($value)
    {
        $this->withTrace = $value;
    }
}
