<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Accounts\ReceiptItemRequest;
use App\Http\Resources\Accounts\ReceiptItemCollection;
use App\Http\Resources\Accounts\ReceiptItemResource;
use App\Models\ReceiptItem;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class ReceiptItemController extends Controller
{
    protected $repository;

    public function __construct(ReceiptItem $ReceiptItem)
    {
        $this->repository= new RepositoryEloquent($ReceiptItem);
    }

    public function index(){

        return ApiResponse::withOk('Receipt Items list',new ReceiptItemCollection($this->repository->all('name')));
    }

    public function show($ReceiptItem){
        $ReceiptItem=$this->repository->show($ReceiptItem);
        return $ReceiptItem?
            ApiResponse::withOk('Receipt Item Found',new ReceiptItemResource($ReceiptItem))
            : ApiResponse::withNotFound('Receipt Item Not Found');
    }

    public function store(ReceiptItemRequest $ReceiptItemRequest){
        try{
            $requestData=$ReceiptItemRequest->all();
            $ReceiptItem=$this->repository->store($requestData);
            return ApiResponse::withOk('Receipt Item created',new ReceiptItemResource($ReceiptItem->refresh()));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function update(ReceiptItemRequest $ReceiptItemRequest,$ReceiptItem){
        try{
            $ReceiptItem=$this->repository->update($ReceiptItemRequest->all(),$ReceiptItem);
            return ApiResponse::withOk('Receipt Item updated',new ReceiptItemResource($ReceiptItem));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Receipt Item deleted successfully');
    }
}
