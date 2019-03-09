<?php

namespace Aleksa\Library\Services;

use Illuminate\Http\Request;

class ApiRequestService
{
    protected $accessToken;

    public function parseRequest(Request $request)
    {
        $this->accessToken = $request->header('al-access-token');
    }

    public function hasToken()
    {
        return $this->accessToken != null;
    }

    public function getToken()
    {
        return $this->accessToken;
    }
}
