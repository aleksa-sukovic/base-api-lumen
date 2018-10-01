<?php

namespace Aleksa\Library\Controllers;

use Aleksa\Library\Controllers\BaseController;

class ObjectController extends BaseController
{
    public function index()
    {
        return 'Index';
    }

    public function show($id)
    {
        $item = $this->repository->findById($id, true);
        return $this->respondSingle($item);
    }

    public function store()
    {
        $params = $this->request->all();

        $item = $this->repository->create($params);

        $item->save();
        return $this->respondSingle($item, 201);
    }

    public function update($id)
    {
        $params = $this->request->all();

        $item = $this->repository->update($id, $params);

        return $this->respondSingle($item, 200);
    }

    public function destroy($id)
    {
        $item = $this->repository->delete($id);

        return $this->respondSingle($item, 200);
    }
}
