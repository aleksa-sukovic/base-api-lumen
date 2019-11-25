<?php

namespace Aleksa\Library\Controllers;

use Aleksa\Library\Controllers\BaseController;
use Aleksa\Library\Facades\Auth;

class ObjectController extends BaseController
{
    protected $repository;

    public function index()
    {
        $this->authorizeAction('index', get_class($this->repository->getModel()));

        $params = $this->request->all();
        $items = $this->repository->all($params);
        $additionalFields = $this->parseAdditionalFields($params);

        return $this->respondCollection($items, 200, 'Success', $additionalFields);
    }

    public function show($id)
    {
        $item = $this->repository->findById($id, true);

        $this->authorizeAction('show', $item);

        return $this->respondSingle($item);
    }

    public function store()
    {
        $this->authorizeAction('store', get_class($this->repository->getModel()));

        $params = $this->request->all();

        $item = $this->repository->create($params);
        $item->save();

        return $this->respondSingle($item, 201);
    }

    public function update($id)
    {
        $this->authorizeAction('update', $this->repository->findById($id));

        $params = $this->request->all();

        $item = $this->repository->update($id, $params);

        return $this->respondSingle($item, 200);
    }

    public function destroy($id)
    {
        $this->authorizeAction('destroy', $this->repository->findById($id));

        $item = $this->repository->delete($id);

        return $this->respondSingle($item, 200);
    }

    protected function authorizeAction(string $method, $item): void
    {
        if (Auth::getUser()) {
            $this->authorizeForUser(Auth::getUser(), $method, $item);
        }
    }

    protected function parseAdditionalFields(array $params): array
    {
        if (!isset($params['additional_fields'])) {
            return [];
        }

        $additionalFields = [];
        $data = explode(',', $params['additional_fields']);

        if (in_array('count', $data)) {
            $additionalFields['count'] = $this->repository->count($params);
        }

        return $additionalFields;
    }
}
