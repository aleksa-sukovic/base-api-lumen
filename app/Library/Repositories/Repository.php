<?php

namespace Aleksa\Library\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface Repository
{
    public function all(array $params): Collection;
    public function save(array $params): Model;
    public function create(array $params): Model;
    public function make(array $params): Model;
    public function update(int $id, array $params): Model;
    public function delete(int $id): Model;
    public function findById(int $id, bool $throw = true): Model;
    public function beforeSave(array $params);
    public function afterSave(Model $item, array $params);
}
