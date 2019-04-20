<?php

namespace Aleksa\Auth\Handlers;

use Aleksa\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Aleksa\Library\Exceptions\AuthException;
use Aleksa\Library\Exceptions\ValidationException;
use Aleksa\Library\Services\Translator;

class TokenPasswordHandler
{
    public function authenticateViaPassword(Request $request): User
    {
        $params = $request->all();
        $validator = Validator::make($params, ['email' => 'required|email', 'password' => 'required']);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

        $user = users()->findByEmail($params['email']);

        if (!Hash::check($params['password'], $user->password)) {
            throw new AuthException(Translator::get('exceptions.auth.password'));
        }

        return $user;
    }

    public function initializePassword(Request $request, User $user)
    {
        $params = $request->all();

        $validator = Validator::make($params, [
            'password'              => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

        $user->password = Hash::make($params['password']);
        $user->save();
    }

    public function resetPassword(Request $request, User $user)
    {
        $params = $request->all();

        $validator = Validator::make($params, [
            'password'              => 'required',
            'password_confirmation' => 'required|same:password',
            'old_password'          => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

        if (!Hash::check($params['old_password'], $user->password)) {
            throw new AuthException(Translator::get('exceptions.auth.password.missmatch'));
        }

        $user->password = Hash::make($params['password']);
        $user->save();
    }
}
