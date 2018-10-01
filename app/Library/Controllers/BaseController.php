<?php

namespace Aleksa\Library\Controllers;

use App\Http\Controllers\Controller;
use League\Fractal\Manager;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class BaseController extends Controller
{
    protected $statusCode;
    protected $transformer;
    protected $fractal;
    protected $repository;
    protected $request;

    public function __construct()
    {
        $this->request    = app('request');
        $this->fractal    = new Manager();
        $this->statusCode = 200;
        $this->fractal->setSerializer(new ArraySerializer);
    }

    public function respondSingle($data, int $statusCode = null, string $message = 'Success', array $additionalData = [], $customTransformer = null)
    {
        if(!$statusCode) {
            $statusCode = $this->getStatusCode();
        }

        $transformer = $this->transformer;
        if ($customTransformer) {
            $transformer = $customTransformer;
        }

        $item = new Item($data, $transformer);
        return $this->respond($this->fractal->createData($item)->toArray(), $statusCode, $message, $additionalData);
    }

    private function respond($data, int $statusCode, string $message = 'Success', array $additionalData = [])
    {
        $responseArray = [
            'message' => $message,
            'status_code' => $statusCode,
            'data' => $data
        ];

        foreach ($additionalData as $key => $value) {
            $responseArray[$key] = $value;
        }

        return response()->json($responseArray)->setStatusCode($statusCode);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
    }
}
