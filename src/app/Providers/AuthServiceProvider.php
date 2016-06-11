<?php

namespace Zikkio\Providers;

use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Zikkio\Auth\Guards\JWTGuard;
use Zikkio\Auth\UserProviders\NodeProvider;
use Zikkio\Policies\Capabilities\Capability;
use Zikkio\Services\JWT\JWTManagerContract;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    ];

    /**
     * The Capability classes for the application
     *
     * @var array
     */
    protected $capabilities = [
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @param AuthManager $auth
     */
    public function boot(GateContract $gate, AuthManager $auth)
    {
        $this->registerCapabilities($gate);
        $this->registerPolicies($gate);
        $this->registerGuards($auth);
        $this->registerUserProviders($auth);
    }

    /**
     * Register any defined authorization capability class
     *
     * @param GateContract $gate
     * @return void
     */
    protected function registerCapabilities(GateContract $gate)
    {
        foreach($this->capabilities as $capabilityClass)
        {
            if(class_exists($capabilityClass))
            {
                $classParents = class_parents($capabilityClass);
                $isCapabilityClass = array_key_exists(Capability::class, $classParents);
                if($isCapabilityClass)
                {
                    call_user_func("$capabilityClass::defineCapabilities", $gate);
                }
            }
        }
    }

    protected function registerGuards(AuthManager $auth)
    {
        $auth->extend('jwt', function($app, $name, array $config) use ($auth) {
            $jwtManager = $app[JWTManagerContract::class];
            $request = $app[Request::class];
            $provider = $auth->createUserProvider($config['provider']);

            return new JWTGuard($jwtManager, $request, $provider);
        });
    }

    protected function registerUserProviders(AuthManager $auth)
    {
        $auth->provider('network', function($app, array $config){
            return $app[NodeProvider::class];
        });
    }
}
