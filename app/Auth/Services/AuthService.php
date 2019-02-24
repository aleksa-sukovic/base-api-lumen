<?php


namespace Aleksa\Auth\Services;

use Illuminate\Http\Request;
use Aleksa\User\Models\User;

interface AuthService
{
    public function authenticateRequest(Request $request);
    public function authenticateUser(Request $request);
    public function refreshAuthentication(Request $request);
    public function revokeAuthentication(Request $request, User $user);
    public function resetCredentials(Request $request, User $user);
}
