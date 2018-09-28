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
        $this->request = app('request');
        $this->fractal = new Manager();
        $this->fractal->setSerializer(new ArraySerializer);
    }

    public function respondSingle($data, string $message = 'Success', array $additionalData = [], $customTransformer = null)
    {
        $transformer = $this->transformer;
        if ($customTransformer) {
            $transformer = $customTransformer;
        }

        $item = new Item($data, $transformer);
        return $this->respond($this->fractal->createData($item)->toArray(), $message, $additionalData);
    }

    private function respond($data, string $message = 'Success', array $additionalData = [])
    {
        $responseArray = [
            'message' => $message,
            'status_code' => $this->getStatusCode(),
            'data' => $data
        ];

        foreach ($additionalData as $key => $value) {
            $responseArray[$key] = $value;
        }

        return response()->json($responseArray)->setStatusCode($this->getStatusCode());
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
