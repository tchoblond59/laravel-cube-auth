<?php

namespace Tchoblond59\CubeAuth\Guards;

use Illuminate\Support\Facades\Session;
use Tchoblond59\CubeAuth\Models\CubeUser;
use Tchoblond59\CubeAuth\Providers\CubeUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Client\Request;

class CubeGuard implements Guard
{

    /**
     * @var string
     */
    private const EMAIL = 'email';

    /**
     * @var string
     */
    private const TOKEN = 'token';

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Create a new authentication guard.
     *
     * @param  \Illuminate\Contracts\Auth\UserProvider  $provider
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(
        CubeUserProvider $provider,
        \Illuminate\Http\Request $request
    )
    {
        $this->provider = $provider;
        $this->request = $request;
    }


    /**
     * @inheritDoc
     */
    public function check()
    {
        if(Session::has('token'))
        {
            $user = $this->provider->retrieveByToken([], Session::get('token'));
            if ($user != null) {
                return $user;
            } else {
                return null;
            }
        }
        else if($this->request->header(self::TOKEN)) {
            $user = $this->provider->retrieveByToken([], $this->request->header('token'));
            return $user;
        }
        else
        {
            return null;
        }
        // TODO: Implement check() method.
    }

    /**
     * @inheritDoc
     */
    public function guest()
    {
        dd('guest');
        return false;
        // TODO: Implement guest() method.
    }

    /**
     * @inheritDoc
     */
    public function user()
    {
        if(Session::has('token'))
        {
            $user = $this->provider->retrieveByToken([], Session::get('token'));
            if ($user != null) {
                return $user;
            } else {
                return null;
            }
        }
        else if($this->request->header(self::TOKEN)) {
            $user = $this->provider->retrieveByToken([], $this->request->header('token'));
            return $user;
        }
        else
        {
            return null;
        }
        // TODO: Implement user() method.

    }

    /**
     * @inheritDoc
     */
    public function id()
    {
        // TODO: Implement id() method.
        $user = $this->provider->retrieveByToken([], Session::get('token'));
    }

    /**
     * @inheritDoc
     */
    public function validate(array $credentials = [])
    {
        dd('validate');
        // TODO: Implement validate() method.
        return $this->provider->validateCredentials(new CubeUser([], ''), $credentials);
    }

    /**
     * @inheritDoc
     */
    public function hasUser()
    {
        // TODO: Implement hasUser() method.
        dd('hasUser');
    }

    /**
     * @inheritDoc
     */
    public function setUser(Authenticatable $user)
    {
        // TODO: Implement setUser() method.
        dd('setUser');
    }

    public function attempt(array $credentials = [], $remember = false)
    {
        return $this->provider->retrieveByCredentials($credentials);
    }
}
