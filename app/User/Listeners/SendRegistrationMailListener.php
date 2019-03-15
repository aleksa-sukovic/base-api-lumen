<?php

namespace Aleksa\User\Listeners;

use Aleksa\User\Events\UserCreated;
use Illuminate\Support\Facades\Log;

class SendRegistrationMailListener
{
    public function handle(UserCreated $event)
    {
        Log::debug('SEND REGISTRATION MAIL');
    }
}
