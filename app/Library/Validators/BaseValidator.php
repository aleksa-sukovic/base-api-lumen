<?php

namespace Aleksa\Library\Validators;

use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Http\Request;
use Aleksa\Library\Exceptions\ValidationException;

class BaseValidator
{
    protected $validator;
    protected $errors;
    protected $rules;
    protected $updateRules;

    public function validate($attributes): bool
    {
        $this->validator = Validator::make($attributes, $this->getRules($attributes));

        if ($this->validator->fails()) {
            $this->errors = $this->validator->errors();
            return false;
        }

        return true;
    }

    public function validateAndHandle($attributes)
    {
        if (!$this->validate($attributes)) {
            throw new ValidationException($this->errors);
        }
    }

    private function getRules($attributes)
    {
        if (array_key_exists('id', $attributes)) {
            return $this->updateRules;
        }

        return $this->rules;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
