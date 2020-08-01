<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Pharmacy\ProductPriceRequest;
use App\Http\Resources\Pharmacy\ProductPriceResource;
use App\Models\ProductPrice;
use App\Repositories\RepositoryEloquent;

class ProductPriceController extends Controller
{
    private $repository;
    public function __construct(ProductPrice $productPrice)
    {
      $this->repository=new RepositoryEloquent($productPrice);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ApiResponse::withOk('Product price list',ProductPriceResource::collection($this->repository->all('created_at','desc')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductPriceRequest $request)
    {
        $record=$this->repository->store($request->only('product_id', 'current_unit_cost', 'previous_unit_cost', 'prepaid_amount', 'postpaid_amount'));
        return ApiResponse::withOk('Product price created',new ProductPriceResource($record->refresh()));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ApiResponse::withOk('Product price found',new ProductPriceResource($this->repository->find($id)));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductPriceRequest $request, $id)
    {
        $record = $this->repository->update($request->only('product_id', 'current_unit_cost', 'previous_unit_cost', 'prepaid_amount', 'postpaid_amount'),$id);
        return ApiResponse::withOk('Product price updated', new ProductPriceResource($record->refresh()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Product price deleted');
    }
}
