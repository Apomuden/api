<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Accounts\DepositRequest;
use App\Http\Resources\Accounts\DepositCollection;
use App\Http\Resources\Accounts\DepositResource;
use App\Models\Deposit;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    protected $repository;

    public function __construct(Deposit $Deposit)
    {
        $this->repository= new RepositoryEloquent($Deposit);
    }

    public function index(){

        return ApiResponse::withOk('Deposits list',new DepositCollection($this->repository->all('name')));
    }

    public function show($Deposit){
        $Deposit=$this->repository->show($Deposit);
        return $Deposit?
            ApiResponse::withOk('Deposit Found',new DepositResource($Deposit))
            : ApiResponse::withNotFound('Deposit Not Found');
    }

    public function store(DepositRequest $DepositRequest){
        if (strtolower(trim($DepositRequest['sponsorship_type']))=='patient') {
            $DepositRequest['billing_sponsor_id'] = null;
            $DepositRequest['patient_sponsor_id'] = null;
        }
        try{
            $requestData=$DepositRequest->all();
            $Deposit=$this->repository->store($requestData);
            return ApiResponse::withOk('Deposit created',new DepositResource($Deposit->refresh()));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function update(DepositRequest $DepositRequest,$Deposit){
        try{
            $Deposit=$this->repository->update($DepositRequest->all(),$Deposit);
            return ApiResponse::withOk('Deposits updated',new DepositResource($Deposit));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Deposit deleted successfully');
    }
}
