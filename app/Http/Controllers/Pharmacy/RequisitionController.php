<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Pharmacy\RequisitionRequest; //TODO: Make Sure to change to the correct Request namespace
use App\Http\Resources\Pharmacy\RequisitionCollection; //TODO: Make Sure to change to the correct Collection namespace
use App\Http\Resources\Pharmacy\RequisitionResource; //TODO: Make Sure to change to the correct Resource namespace
use App\Models\Requisition; //TODO: Make Sure to change to the correct Model namespace
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class RequisitionController extends Controller
{
    protected $repository;

    public function __construct(Requisition $Requisition)
    {
        $this->repository= new RepositoryEloquent($Requisition);
    }

    public function index(){

        return ApiResponse::withOk('Requisitions list',new RequisitionCollection($this->repository->all('name')));
    }

    public function show($Requisition){
        $Requisition=$this->repository->show($Requisition);
        return $Requisition?
            ApiResponse::withOk('Requisition Found',new RequisitionResource($Requisition))
            : ApiResponse::withNotFound('Requisition Not Found');
    }

    public function store(RequisitionRequest $RequisitionRequest){
        try{
            $requestData=$RequisitionRequest->all();
            $Requisition=$this->repository->store($requestData);
            return ApiResponse::withOk('Requisition created',new RequisitionResource($Requisition->refresh()));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function update(RequisitionRequest $RequisitionRequest,$Requisition){
        try{
            $Requisition=$this->repository->update($RequisitionRequest->all(),$Requisition);
            return ApiResponse::withOk('Requisition updated',new RequisitionResource($Requisition));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Requisition deleted successfully');
    }
}
