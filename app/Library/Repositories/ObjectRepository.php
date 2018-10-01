<?php

namespace Aleksa\Library\Repositories;

use Aleksa\Library\Exceptions\ItemNotFoundException;
use Aleksa\Library\Exceptions\BaseException;

class ObjectRepository
{
    protected $model;
    protected $validator;

    public function create($params)
    {
        $this->validator->validateAndHandle($params);

        $modelClass = get_class($this->model);
        $item = new $modelClass($params);

        return $item;
    }

    public function update($id, $params)
    {
        $params['id'] = $id;
        $this->validator->validateAndHandle($params);

        $item   = $this->findById($id);
        $result = $item->update($params);
        
        if(!$result) {
            throw new BaseException(400, "Could not update the item");
        }

        return $item;
    }

    public function delete($id)
    {
        $item = $this->findById($id, true);

        $item->delete();

        return $item;
    }

    public function findById($id, $throwException = false)
    {
        $model = $this->model;
        $item = $model->where('id', '=', $id)->first();

        if (!$item && $throwException) {
            throw new ItemNotFoundException;
        }

        return $item;
    }
}
