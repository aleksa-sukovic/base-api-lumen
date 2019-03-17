<?php

namespace Aleksa\Library\Repositories;

use Aleksa\Library\Exceptions\ItemNotFoundException;
use Aleksa\Library\Exceptions\ItemNotSavedException;
use Aleksa\Library\Exceptions\ItemNotUpdatedException;
use Aleksa\Library\Repositories\Repository;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class ObjectRepository implements Repository
{
    protected $model;
    protected $queryProcessor;
    protected $validator;
    protected $saveEvent;
    protected $createEvent;
    protected $deleteEvent;

    public function all(array $params): Collection
    {
        $params = $this->processParams($params);

        $query = $this->queryProcessor->process($this->model->newQuery(), $params);

        $items = $query->get();

        return $items;
    }

    public function save(array $params): Model
    {
        if (isset($params['id'])) {
            return $this->update($params['id'], $params);
        }

        return $this->create($params);
    }

    public function create(array $params): Model
    {
        $params = $this->processParams($params);

        $this->validator->validateAndHandle($params);

        $modelClass = get_class($this->model);
        $item = new $modelClass($params);

        $this->beforeSave($params, null);
        $item->save();
        if (!$item) {
            throw new ItemNotSavedException;
        }
        $this->afterSave($item, $params);

        $this->throwEvent($this->createEvent, $item);
        $this->throwEvent($this->saveEvent, $item);

        return $item;
    }

    public function make(array $params): Model
    {
        $params = $this->processParams($params);
        $this->validator->validateAndHandle($params);

        $modelClass = get_class($this->model);
        $item = new $modelClass($params);

        return $item;
    }

    public function update(int $id, array $params): Model
    {
        $params = $this->processParams($params);
        $params['id'] = $id;
        $this->validator->validateAndHandle($params);

        $item = $this->findById($id);

        $this->beforeSave($params, $item);
        $result = $item->update($params);
        $this->afterSave($item, $params);

        if (!$result) {
            throw new ItemNotUpdatedException;
        }

        $this->throwEvent($this->saveEvent, $item);

        return $item;
    }

    public function delete(int $id): Model
    {
        $item = $this->findById($id);

        $item->delete();

        $this->throwEvent($this->deleteEvent, $item);

        return $item;
    }

    public function findById(int $id, bool $throw = true): Model
    {
        $model = $this->model;
        $item = $model->where('id', '=', $id)->first();

        if (!$item && $throw) {
            throw new ItemNotFoundException;
        }

        return $item;
    }

    public function beforeSave(array $params, ?Model $model)
    {
        //
    }

    public function afterSave(Model $item, array $params)
    {
        //
    }

    public function processParams($params = []): array
    {
        return $params;
    }

    protected function throwEvent($eventClass, $object = null): void
    {
        if ($eventClass) {
            event(new $eventClass($object));
        }
    }

    public function getModel(): Model
    {
        return $this->model;
    }
}
