<?php

namespace App\Http\Middleware;

use App\Http\Helpers\ApiRequest;
use App\Http\Helpers\ApiResponse;
use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Cache;
use App\Models\ComponentUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class RolesAuth extends BaseMiddleware
{
    protected $user;
    public function authenticate(Request $request)
    {
        $this->checkForToken($request);

        try {
            if (!($this->user = $this->auth->parseToken()->authenticate())) {
                throw new UnauthorizedHttpException('jwt-auth', 'User not found');
            }

            //Log::critical('Role', [$this->user]);
        } catch (JWTException $e) {
            throw new UnauthorizedHttpException('jwt-auth', $e->getMessage(), $e, $e->getCode());
        }
    }

    public function handle($request, Closure $next)
    {

        $this->authenticate($request);

        // get user role permissions
            $user = $this->user;
            $role = $this->user->role;

            //Log::critical('Role',[$role]);

        if (!$role || $role->status != 'ACTIVE') {
            return ApiResponse::withNotAuthorized('Role not Active or Deleted');
        } elseif (ucwords($role->name) == 'Dev') {
            return $next($request);
        } else {
            $route = $request->route();
            $action = $route->getAction();
            $name = $route->getName();
            $module = $action['module'] ?? null;
            $component = $action['component'] ?? null;

            $nameParts = explode('.', $name);
            $operation = strtolower(end($nameParts));
            //Log::critical('action',[$operation]);

            switch ($operation) {
                case 'index':
                case 'view':
                case 'show':
                    $operation = 'view';
                    break;

                case 'store':
                case 'create':
                       $operation = 'add';
                    break;

                case 'update':
                case 'edit':
                       $operation = 'edit';
                    break;

                case 'delete':
                case 'destroy':
                        $operation = 'delete';
                    break;

                case 'print':
                case 'export':
                        $operation = 'print';
                    break;
                default:
                    if (ApiRequest::startsWith($operation, 'create')) {
                        $operation = 'add';
                    } elseif (ApiRequest::startsWith($operation, 'update')) {
                        $operation = 'edit';
                    }
                    break;
            }

            $componentParts = explode('.', $component);

          //Incase it is a free route
            if (!$module || !$component) {
                return $next($request);
            } elseif ((ApiRequest::endsWith($name, 'index') || ApiRequest::endsWith($name, 'view')) && ((isset($componentParts[1]) && $componentParts[1] == 'free') || (isset($componentParts[0]) && $componentParts[0] == 'free'))) {
                return $next($request);
            } else {
                $key = 'components->user->' . $user->id;
                $components = Cache::get($key) ?? null;
                if (!$components) {
                    $components = $user->components()->active()->orderBy('name')->get();
                    Cache::forever('components->user->' . $user->id, $components);
                }
                foreach ($components as $dbcomponent) {
                    if (strtolower($dbcomponent->tag) == strtolower($component)) {
                        $permissions = ComponentUser::where('component_id', $dbcomponent->id)
                                       ->where('user_id', $user->id)
                                       ->first(['all','add','view','edit','update','delete','print']);

                        if ($operation == 'add' && $permissions->add) {
                            return $next($request);
                        } elseif ($operation == 'view' && $permissions->view) {
                            return $next($request);
                        } elseif ($operation == 'edit' && $permissions->edit) {
                            return $next($request);
                        } elseif ($operation == 'update' && $permissions->update) {
                            return $next($request);
                        } elseif ($operation == 'delete' && $permissions->delete) {
                            return $next($request);
                        } elseif ($operation == 'print' && $permissions->print) {
                            return $next($request);
                        }
                    }
                }// none authorized request
            }
        }
        return ApiResponse::withNotAuthorized('Unauthorized Action');
    }
}
