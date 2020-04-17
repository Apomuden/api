<?php

namespace App\Http\Resources\Pharmacy;

use App\Http\Requests\Pharmacy\ProductFormUnitRequest;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductFormUnitCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ProductFormUnitResource::collection($this->collection);
    }
}
