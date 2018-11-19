<?php

namespace Aleksa\Library\Exceptions;

use Aleksa\Library\Exceptions\BaseException;
use Illuminate\Http\JsonResponse;

class ItemNotFoundException extends BaseException
{
    public function __construct($message = 'Item not found')
    {
        parent::__construct(404, $message);
    }

    public function toArray()
    {
        $array         = parent::toArray();
        $array['data'] = [];
        return $array;
    }
}
