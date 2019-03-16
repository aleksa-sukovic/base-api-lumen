<?php

namespace Aleksa\User\Emails;

use Illuminate\Mail\Mailable;
use Illuminate\Database\Eloquent\Model;
use Aleksa\Library\Services\LocaleService;
use Aleksa\Library\Services\Translator;

class UserRegistrationMail extends Mailable
{

    /**
     * @var Aleksa\User\Models\User
     */
    protected $user;

    public function __construct(Model $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.auth.welcome_' . LocaleService::get()->code)
            ->subject(Translator::get('emails.registration'))
            ->with('user', $this->user)
            ->to($this->user->email);
    }
}
