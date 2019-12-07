<?php

namespace App\Http\Middleware;

use App\Http\Helpers\ApiResponse;
use App\Models\Role;
use Closure;

class RolesAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // get user role permissions
            $role = auth('api')->user()->role;
            if($role->name=='Admin')
               return $next($request);
            else{
                $permissions = $role->permissions;// get requested action
                $actionName = class_basename($request->route()->getActionname());// check if requested action is in permissions list
                foreach ($permissions as $permission)
                {
                    $_namespaces_chunks = explode('\\', $permission->controller);
                    $controller = end($_namespaces_chunks);
                    if ($actionName == $controller . '@' . $permission->method)
                    // authorized request
                    return $next($request);

                }// none authorized request
                return ApiResponse::withNotAuthorized('Unauthorized Action');
            }

    }
}
