<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Pharmacy\StoreRequest;
use App\Http\Resources\Pharmacy\StoreCollection;
use App\Http\Resources\Pharmacy\StoreResource;
use App\Models\Store;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    protected $repository;

    public function __construct(Store $Store)
    {
        $this->repository= new RepositoryEloquent($Store);
    }

    public function index(){

        return ApiResponse::withOk('Product Forms list',new StoreCollection($this->repository->all('name')));
    }

    public function show($Store){
        $Store=$this->repository->show($Store);
        return $Store?
            ApiResponse::withOk('Product Form Found',new StoreResource($Store))
            : ApiResponse::withNotFound('Product Form Not Found');
    }

    public function store(StoreRequest $StoreRequest){
        try{
            $requestData=$StoreRequest->all();
            $Store=$this->repository->store($requestData);
            return ApiResponse::withOk('Product Form created',new StoreResource($Store->refresh()));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function update(StoreRequest $StoreRequest,$Store){
        try{
            $Store=$this->repository->update($StoreRequest->all(),$Store);
            return ApiResponse::withOk('Product Form updated',new StoreResource($Store));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Product Form deleted successfully');
    }
}
