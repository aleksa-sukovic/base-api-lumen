<?php

namespace Aleksa\Library\Exceptions;

use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Exception;
use InvalidArgumentException;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        'Symfony\Component\HttpKernel\Exception\HttpException'
    ];

    public function report(Exception $exception)
    {
        if (!$this->isCustomException($exception)) {
            parent::report($exception);
        }
    }

    public function render($request, Exception $exception)
    {
        if ($this->isCustomException($exception)) {
            return $this->renderCustomException($exception);
        }

        return $this->renderJson($exception);
    }

    private function isCustomException($exception)
    {
        return get_class($exception) == 'Aleksa\Library\Exceptions\BaseException' || is_subclass_of($exception, 'Aleksa\Library\Exceptions\BaseException');
    }

    private function renderCustomException($exception)
    {
        try {
            return response()->json($exception->toArray());
        } catch (InvalidArgumentException $e) {
            $exception->isWithTrace(false);
            return response()->json($exception->toArray(), $exception->getStatusCode());
        }
    }

    private function renderJson($exception)
    {
        $data = [
            'class'       => get_class($exception),
            'status_code' => $exception->getCode(),
            'file'        => $exception->getFile(),
            'message'     => $exception->getMessage()
        ];

        try {
            $data['trace'] = $exception->getTrace();
            return response()->json($data);
        } catch (InvalidArgumentException $e) {
            unset($data['trace']);
            return response()->json($data);
        }
    }
}
