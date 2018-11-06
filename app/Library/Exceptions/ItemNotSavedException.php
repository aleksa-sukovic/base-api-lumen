<?php

namespace Aleksa\Library\Exceptions;

use Aleksa\Library\Exceptions\BaseException;
use Illuminate\Http\JsonResponse;

class ItemNotSavedException extends BaseException
{
    public function __construct()
    {
        parent::__construct(400, 'Item not saved');
    }
}
