<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerRequestRebindHandler();

        //
    }

    protected function registerRequestRebindHandler()
    {
            $this->app->rebinding('request', function ($app, $request) {
                        $request->setUserResolver(function ($guard = null) use ($app) {
                                return call_user_func($app['auth']->userResolver(), $guard);
                        });
            });
    }



}
