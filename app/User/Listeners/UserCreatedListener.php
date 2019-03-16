<?php

namespace Aleksa\User\Listeners;

use Aleksa\User\Events\UserCreated;
use Illuminate\Support\Facades\Mail;
use Aleksa\User\Emails\UserRegistrationMail;

class UserCreatedListener
{
    public function handle(UserCreated $event)
    {
        Mail::send(new UserRegistrationMail($event->getObject()));
    }
}
