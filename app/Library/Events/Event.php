<?php

namespace Aleksa\Library\Events;

use Illuminate\Database\Eloquent\Model;

abstract class Event
{

    /**
     * @var Illuminate\Database\Eloquent\Model;
     */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getObject()
    {
        return $this->model;
    }
}
