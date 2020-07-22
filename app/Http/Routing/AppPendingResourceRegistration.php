<?php

namespace App\Http\Routing;

use Illuminate\Routing\PendingResourceRegistration;
use Illuminate\Support\Facades\Log;

class AppPendingResourceRegistration extends PendingResourceRegistration
{
    public function __construct(AppResourceRegistrar $registrar, $name, $controller, array $options)
    {
        parent::__construct($registrar, $name, $controller, $options);
    }
    public function options($options)
    {
        $this->options['tags'] = (is_array($options) ? $options : func_get_args());

        return $this;
    }
}
