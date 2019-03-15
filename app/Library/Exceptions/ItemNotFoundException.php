<?php

namespace Aleksa\Library\Exceptions;

use Aleksa\Library\Exceptions\BaseException;
use Aleksa\Library\Services\Translator;

class ItemNotFoundException extends BaseException
{
    public function __construct($message = null)
    {
        if (!$message) {
            $message = Translator::get('exceptions.item.not_found');
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
