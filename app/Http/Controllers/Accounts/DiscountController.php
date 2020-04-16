<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Accounts\DiscountRequest;
use App\Http\Resources\Accounts\DiscountCollection;
use App\Http\Resources\Accounts\DiscountResource;
use App\Models\Discount;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    protected $repository;

    public function __construct(Discount $Discount)
    {
        $this->repository= new RepositoryEloquent($Discount);
    }

    public function index(){

        return ApiResponse::withOk('Discounts list',new DiscountCollection($this->repository->all('name')));
    }

    public function show($Discount){
        $Discount=$this->repository->show($Discount);
        return $Discount?
            ApiResponse::withOk('Discount Found',new DiscountResource($Discount))
            : ApiResponse::withNotFound('Discount Not Found');
    }

    public function store(DiscountRequest $DiscountRequest){
        if (strtolower(trim($DiscountRequest['sponsorship_type']))=='patient') {
            $DiscountRequest['billing_sponsor_id'] = null;
            $DiscountRequest['patient_sponsor_id'] = null;
        }
        try{
            $requestData=$DiscountRequest->all();
            $Discount=$this->repository->store($requestData);
            return ApiResponse::withOk('Discount created',new DiscountResource($Discount->refresh()));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function update(DiscountRequest $DiscountRequest,$Discount){
        try{
            $Discount=$this->repository->update($DiscountRequest->all(),$Discount);
            return ApiResponse::withOk('Discounts updated',new DiscountResource($Discount));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Discount deleted successfully');
    }
}
