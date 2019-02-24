<?php

namespace Aleksa\Library\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class BaseException extends Exception
{
    protected $statusCode;
    protected $withTrace;

    public function __construct($statusCode = 500, $message = '', $withTrace = true)
    {
        $this->statusCode = $statusCode;
        $this->withTrace = $withTrace;
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
            'message'     => $this->message
        ];
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function withTrace($value)
    {
        $this->withTrace = $value;
    }
}
