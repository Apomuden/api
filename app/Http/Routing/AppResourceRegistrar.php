<?php

namespace App\Http\Routing;

use Illuminate\Routing\ResourceRegistrar;

class AppResourceRegistrar extends ResourceRegistrar{
    protected function getResourceAction($resource, $controller, $method, $options)
    {
        $name = $this->getResourceRouteName($resource, $method, $options);

        $action = ['as' => $name, 'uses' => $controller . '@' . $method];

        if(isset($options['tags']))
        $action= array_merge($action, $options);
        else if(isset($options['module'], $options['component']))
            $action = array_merge($action, ['module'=> $options['module'], 'component'=>$options['component'], 'parent_module'=>($options['parent_module']??null)]);

        if (isset($options['middleware'])) {
            $action['middleware'] = $options['middleware'];
        }

        return $action;
    }
    protected function getResourceRouteName($resource, $method, $options)
    {
        $name = $resource;

        // If the names array has been provided to us we will check for an entry in the
        // array first. We will also check for the specific method within this array
        // so the names may be specified on a more "granular" level using methods.
        if (isset($options['names'])) {
            if (is_string($options['names'])) {
                $name = $options['names'];
            } elseif (isset($options['names'][$method])) {
                return $options['names'][$method];
            }
        }

        // If a global prefix has been assigned to all names for this resource, we will
        // grab that so we can prepend it onto the name when we create this name for
        // the resource action. Otherwise we'll just use an empty string for here.
        $prefix = isset($options['as']) ? $options['as'] . '.' : '';

        return trim(sprintf('%s%s.%s', $prefix, $name, $method), '.');
    }
}
