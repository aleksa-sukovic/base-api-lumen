<?php

namespace Aleksa\Library\Exceptions;

use Aleksa\Library\Exceptions\BaseException;
use Aleksa\Library\Services\Translator;

class RouteNotFoundException extends BaseException
{
    public function __construct($message = null)
    {
        if (!$message) {
            $message = Translator::get('exceptions.route.not_found');
        }

        parent::__construct(404, $message);
    }

    public function toArray()
    {
        return [
            'status_code' => $this->getStatusCode(),
            'message'     => $this->getMessage(),
            'data'        => []
        ];
    }
}
