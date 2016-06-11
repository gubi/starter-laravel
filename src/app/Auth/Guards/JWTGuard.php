<?php

namespace Zikkio\Auth\Guards;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Zikkio\Services\JWT\JWTManagerContract;

class JWTGuard implements Guard
{
    use GuardHelpers;

    protected $jwt;
    protected $request;

    public function __construct(JWTManagerContract $jwt, Request $request, UserProvider $provider)
    {
        $this->jwt = $jwt;
        $this->request = $request;
        $this->provider = $provider;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        if (! is_null($this->user))
        {
            return $this->user;
        }

        $user = null;

        $token = $this->getTokenForRequest();
        if (! empty($token))
        {
            $userId = $this->jwt->get($token, 'sub');

            $user = $this->provider->retrieveById($userId);
        }

        return $this->user = $user;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        if($this->provider->retrieveByCredentials($credentials))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Fetches the token from the request
     */
    public function getTokenForRequest(){
        return $this->request->bearerToken();
    }
}