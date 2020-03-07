<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Accounts\EreceiptRequest;
use App\Http\Resources\Accounts\EreceiptCollection;
use App\Http\Resources\Accounts\EreceiptResource;
use App\Models\Ereceipt;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class EreceiptController extends Controller
{
    protected $repository;

    public function __construct(Ereceipt $Ereceipt)
    {
        $this->repository= new RepositoryEloquent($Ereceipt);
    }

    public function index(){

        return ApiResponse::withOk('E-receipts list',new EreceiptCollection($this->repository->all('name')));
    }

    public function show($Ereceipt){
        $Ereceipt=$this->repository->show($Ereceipt);
        return $Ereceipt?
            ApiResponse::withOk('E-receipt Found',new EreceiptResource($Ereceipt))
            : ApiResponse::withNotFound('E-receipt Not Found');
    }

    public function store(EreceiptRequest $EreceiptRequest){
        try{
            $requestData=$EreceiptRequest->all();
            $Ereceipt=$this->repository->store($requestData);
            return ApiResponse::withOk('E-receipt created',new EreceiptResource($Ereceipt->refresh()));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function update(EreceiptRequest $EreceiptRequest,$Ereceipt){
        try{
            $Ereceipt=$this->repository->update($EreceiptRequest->all(),$Ereceipt);
            return ApiResponse::withOk('E-receipt updated',new EreceiptResource($Ereceipt));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('E-receipt deleted successfully');
    }
}
