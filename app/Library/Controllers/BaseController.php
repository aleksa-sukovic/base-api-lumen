<?php

namespace Aleksa\Library\Controllers;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;
use League\Fractal\Serializer\ArraySerializer;
use Laravel\Lumen\Routing\Controller;

class BaseController extends Controller
{
    protected $statusCode;
    protected $transformer;
    protected $request;
    protected $fractal;

    public function __construct()
    {
        $this->request = app('request');
        $this->fractal = new Manager();
        $this->statusCode = 200;
        $this->fractal->setSerializer(new ArraySerializer);
        $this->parseIncludes();
    }

    protected function parseIncludes()
    {
        if (!$this->request->isMethod('get')) {
            return;
        }

        if (!$this->request->has('include')) {
            return;
        }

        $includes = $this->request->input('include');
        $this->fractal->parseIncludes($includes);
    }


    public function respondSingle($data, int $statusCode = null, string $message = 'Success', array $additionalData = [], $customTransformer = null)
    {
        if (!$statusCode) {
            $statusCode = $this->getStatusCode();
        }

        $transformer = $this->transformer;
        if ($customTransformer) {
            $transformer = $customTransformer;
        }

        $item = new Item($data, $transformer);
        return $this->respond($this->fractal->createData($item)->toArray(), $statusCode, $message, $additionalData);
    }

    public function respondCollection($data, int $statusCode = null, string $message = 'Success', array $additionalData = [], $customTransformer = null)
    {
        if (!$statusCode) {
            $statusCode = $this->getStatusCode();
        }

        $transformer = $this->transformer;
        if ($customTransformer) {
            $transformer = $customTransformer;
        }

        $collection = new Collection($data, $transformer);
        return $this->respond($this->fractal->createData($collection)->toArray(), $statusCode, $message, $additionalData);
    }

    public function respond($data, int $statusCode, string $message = 'Success', array $additionalData = [])
    {
        $responseArray = [
            'message'     => $message,
            'status_code' => $statusCode,
        ];

        $responseArray['data'] = $data;
        if (array_key_exists('data', $data)) {
            $responseArray['data'] = $data['data'];
        }

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
