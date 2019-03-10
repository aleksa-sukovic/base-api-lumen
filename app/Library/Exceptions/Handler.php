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
        parent::report($exception);
    }

    public function render($request, Exception $exception)
    {
        if ($this->isCustomException($exception)) {
            return $this->renderCustomException($exception, $exception->getStatusCode());
        }

        return $this->renderSystemExceptions($exception);
    }

    private function isCustomException(Exception $exception)
    {
        return get_class($exception) == 'Aleksa\Library\Exceptions\BaseException' || is_subclass_of($exception, 'Aleksa\Library\Exceptions\BaseException');
    }

    private function renderCustomException(Exception $exception)
    {
        return $this->respond($exception->toArray(), $exception->getStatusCode());
    }

    private function renderSystemExceptions(Exception $exception)
    {
        if (get_class($exception) == 'Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException') {
            return $this->renderCustomException(new MethodNotAllowedException);
        } elseif (get_class($exception) == 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException') {
            return $this->renderCustomException(new RouteNotFoundException);
        } elseif (get_class($exception) == 'Illuminate\Auth\Access\AuthorizationException') {
            return $this->renderCustomException(new UnauthorizedException);
        } else {
            return $this->renderJson($exception);
        }
    }

    private function renderJson(Exception $exception)
    {
        if (env('APP_DEBUG')) {
            $data = $this->renderDebugJson($exception);
        } else {
            $data = $this->renderProductionJson($exception);
        }

        return $this->respond($data);
    }

    private function renderDebugJson(Exception $exception)
    {
        return [
            'status_code' => $exception->getCode(),
            'message'     => $exception->getMessage(),
            'class'       => get_class($exception),
            'line'        => $exception->getLine(),
            'trace'       => $exception->getTrace()
        ];
    }

    private function renderProductionJson(Exception $exception)
    {
        return [
            'status_code' => $exception->getCode(),
            'message'     => $exception->getMessage()
        ];
    }

    private function respond(array $data, $statusCode = null)
    {
        if (!$statusCode) {
            $statusCode = 500;
        }

        try {
            return response()->json($data)->setStatusCode($statusCode);
        } catch (InvalidArgumentException $e) {
            unset($data['trace']);

            return response()->json($data)->setStatusCode($statusCode);
        }
    }
}
