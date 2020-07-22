<?php

namespace App\Http\Foundation;

use App\Http\Routing\AppRoutingServiceProvider;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Log\LogServiceProvider;
use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{
    protected function registerBaseServiceProviders()
    {
        $this->register(new EventServiceProvider($this));
        $this->register(new LogServiceProvider($this));
        $this->register(new AppRoutingServiceProvider($this));
    }
}
