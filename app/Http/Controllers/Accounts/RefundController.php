<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Accounts\RefundRequest;
use App\Http\Resources\Accounts\RefundCollection;
use App\Http\Resources\Accounts\RefundResource;
use App\Models\Refund;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    protected $repository;

    public function __construct(Refund $Refund)
    {
        $this->repository= new RepositoryEloquent($Refund);
    }

    public function index(){

        return ApiResponse::withOk('Refunds list',new RefundCollection($this->repository->all('name')));
    }

    public function show($Refund){
        $Refund=$this->repository->show($Refund);
        return $Refund?
            ApiResponse::withOk('Refund Found',new RefundResource($Refund))
            : ApiResponse::withNotFound('Refund Not Found');
    }

    public function store(RefundRequest $RefundRequest){
        try{
            $requestData=$RefundRequest->all();
            $Refund=$this->repository->store($requestData);
            return ApiResponse::withOk('Refund created',new RefundResource($Refund->refresh()));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function update(RefundRequest $RefundRequest,$Refund){
        try{
            $Refund=$this->repository->update($RefundRequest->all(),$Refund);
            return ApiResponse::withOk('Refunds updated',new RefundResource($Refund));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Refund deleted successfully');
    }
}
