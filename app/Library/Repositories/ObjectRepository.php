<?php

namespace Aleksa\Library\Repositories;

use Aleksa\Library\Exceptions\ItemNotFoundException;
use Aleksa\Library\Exceptions\ItemNotSavedException;
use Aleksa\Library\Exceptions\ItemNotUpdatedException;

class ObjectRepository
{
    protected $model;
    protected $queryProcessor;
    protected $validator;

    public function all($params)
    {
        $query = $this->queryProcessor->process($this->model->newQuery(), $params);

        $items = $query->get();

        return $items;
    }

    public function create($params, $save = true)
    {
        $this->validator->validateAndHandle($params);

        $modelClass = get_class($this->model);
        $item = new $modelClass($params);

        if (!$save) {
            return $item;
        }

        $this->beforeSave($item);
        $item = $item->save();
        if (!$item) {
            throw new ItemNotSavedException;
        }
        $this->afterSave($item);

        return $item;
    }

    public function update($id, $params)
    {
        $params['id'] = $id;
        $this->validator->validateAndHandle($params);

        $item   = $this->findById($id);

        $this->beforeSave($item);
        $result = $item->update($params);
        $this->afterSave($item);

        if (!$result) {
            throw new ItemNotUpdatedException;
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

    protected function beforeSave($item)
    {
        //
    }

    protected function afterSave($item)
    {
        //
    }
}
