<?php

namespace App\Http\Routing;

use Illuminate\Routing\RoutingServiceProvider;

class AppRoutingServiceProvider extends RoutingServiceProvider{
    protected function registerRouter()
    {
        $this->app->singleton('router', function ($app) {
            return new AppRouter($app['events'], $app);
        });
    }
}
