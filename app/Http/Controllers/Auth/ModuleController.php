<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Resources\GeneralCollection;
use App\Http\Resources\GeneralResource;
use App\Models\Module;
use App\Models\Role;
use App\Repositories\RepositoryEloquent;
use Exception;

class ModuleController extends Controller
{
    protected $repository;
    public function __construct(Module $module)
    {
        $this->repository= new RepositoryEloquent($module);
    }
    function index(){
        return ApiResponse::withOk('Module list',new GeneralCollection($this->repository->all('name')));
    }
    function show($module){
        $module=$this->repository->show($module);//pass the country
        return $module?
        ApiResponse::withOk('Module Found',new GeneralResource($module))
        : ApiResponse::withNotFound('Module Not Found');
    }
}
