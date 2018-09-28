<?php

namespace Aleksa\Library\Repositories;

use Aleksa\Library\Exceptions\ItemNotFoundException;

class ObjectRepository
{
    protected $model;

    public function findById($id)
    {
        $model = $this->model;
        $item = $model->where('id', '=', $id)->first();

        if (!$item) {
            throw new ItemNotFoundException;
        }

        return $item;
    }
}
