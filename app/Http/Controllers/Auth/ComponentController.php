<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Resources\ComponentCollection;
use App\Http\Resources\GeneralCollection;
use App\Http\Resources\GeneralResource;
use App\Models\Component;
use App\Models\Module;
use App\Repositories\RepositoryEloquent;
use Exception;

class ComponentController extends Controller
{
    protected $repository;

    public function __construct(Component $component)
    {
        $this->repository= new RepositoryEloquent($component,true);
    }
    function index(){
        $components=$this->repository->paginate(10,'name');
        return ApiResponse::withPaginate(new ComponentCollection($components,'Components list'));    }
    function show($component){
        $component=$this->repository->show($component);//pass the country
        return $component?
        ApiResponse::withOk('Component Found',new GeneralResource($component))
        : ApiResponse::withNotFound('Component Not Found');
    }

    function showByModule($module){
        $this->repository->setModel(new Module);

        $components=$this->repository->getInstanceWith(['components'=>function($query){
            $query->active()->orderBy('name')->sortBy('name')->paginate(10);
        }])->find($module)->components;

        return ApiResponse::withOk('Available Components', GeneralResource::collection($components));
    }
}
