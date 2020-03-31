<?php

namespace App\Http\Routing;

use Illuminate\Container\Container;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;

class AppRouter extends Router{

    public function __construct(Dispatcher $events, Container $container = null)
    {
       parent::__construct($events,$container);
    }
    public function resource($name, $controller, array $options = [])
    {
        if ($this->container && $this->container->bound(AppResourceRegistrar::class)) {
            $registrar = $this->container->make(AppResourceRegistrar::class);
        } else {
            $registrar = new AppResourceRegistrar($this);
        }

        return new AppPendingResourceRegistration(
            $registrar,
            $name,
            $controller,
            $options
        );
    }
}
