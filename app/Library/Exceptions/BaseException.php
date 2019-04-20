<?php

namespace Aleksa\Library\Exceptions;

use Exception;

class BaseException extends Exception
{
    protected $statusCode;
    protected $withTrace;
    protected $exceptionCode;

    public function __construct($statusCode = 500, $message = '', $exceptionCode = null, $withTrace = true)
    {
        $this->statusCode = $statusCode;
        $this->withTrace = $withTrace;
        $this->exceptionCode = $exceptionCode;

        parent::__construct($message);
    }

    public function render()
    {
        return response()->json($this->toArray(), $this->getStatusCode());
    }

    public function toArray()
    {
        if (env('APP_DEBUG')) {
            return $this->toDebugArray();
        }

        return $this->toProductionArray();
    }

    protected function toDebugArray()
    {
        $data = [
            'status_code' => $this->getStatusCode(),
            'code'        => $this->getExceptionCode(),
            'message'     => $this->getMessage(),
            'class'       => get_class($this),
            'line'        => $this->getLine(),
        ];

        if ($this->withTrace) {
            $data['trace'] = $this->getTrace();
        }

        return $data;
    }

    protected function toProductionArray()
    {
        return [
            'status_code' => $this->getStatusCode(),
            'code'        => $this->getExceptionCode(),
            'message'     => $this->message
        ];
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getExceptionCode()
    {
        return $this->exceptionCode;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function setExceptionCode($exceptionCode)
    {
        $this->exceptionCode = $exceptionCode;
    }

    public function withTrace($value)
    {
        $this->withTrace = $value;
    }
}
