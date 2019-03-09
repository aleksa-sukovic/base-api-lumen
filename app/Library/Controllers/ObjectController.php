<?php

namespace Aleksa\Library\Controllers;

use Aleksa\Library\Controllers\BaseController;
use Aleksa\Library\Facades\Auth;

class ObjectController extends BaseController
{
    protected $repository;

    public function index()
    {
        $this->authorizeForUser(Auth::getUser(), 'index', get_class($this->repository->getModel()));

        $params = $this->request->all();

        $items = $this->repository->all($params);
        return $this->respondCollection($items, 200);
    }

    public function show($id)
    {
        $item = $this->repository->findById($id, true);

        $this->authorizeForUser(Auth::getUser(), 'show', $item);

        return $this->respondSingle($item);
    }

    public function store()
    {
        $this->authorizeForUser(Auth::getUser(), 'store', get_class($this->repository->getModel()));

        $params = $this->request->all();

        $item = $this->repository->create($params);
        $item->save();

        return $this->respondSingle($item, 201);
    }

    public function update($id)
    {
        $this->authorizeForUser(Auth::getUser(), 'update', $this->repository->findById($id));

        $params = $this->request->all();

        $item = $this->repository->update($id, $params);

        return $this->respondSingle($item, 200);
    }

    public function destroy($id)
    {
        $this->authorizeForUser(Auth::getUser(), 'destroy', $this->repository->findById($id));

        $item = $this->repository->delete($id);

        return $this->respondSingle($item, 200);
    }
}
