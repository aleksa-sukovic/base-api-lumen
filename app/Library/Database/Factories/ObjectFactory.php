<?php

namespace Aleksa\Library\Database\Factories;

use Illuminate\Database\Eloquent\Factory;
use Faker\Generator;

abstract class ObjectFactory
{
    /**
     * @var Factory
     */
    protected $factory;
    protected $modelClass;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function register()
    {
        $this->registerModel();
        $this->registerStates();
    }

    protected function registerModel()
    {
        $instance = $this;

        $this->factory->define($this->modelClass, function (Generator $generator) use ($instance) {
            return $instance->make($generator);
        });
    }

    protected function registerStates()
    {
        //
    }

    abstract protected function make(Generator $generator): array;
}
