<?php

namespace Aleksa\Library\Exceptions;

use Aleksa\Library\Exceptions\BaseException;
use Aleksa\Library\Services\Translator;

class ItemNotUpdatedException extends BaseException
{
    public function __construct()
    {
        parent::__construct(400, Translator::get('exceptions.item.not_updated'));
    }
}
