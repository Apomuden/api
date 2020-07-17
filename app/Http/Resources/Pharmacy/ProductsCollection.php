<?php

namespace App\Http\Resources\Pharmacy;

use App\Http\Resources\Helpers\PaginatedCollectionHelper;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductsCollection extends PaginatedCollectionHelper
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request, $coll = null)
    {
        return parent::toArray($request, ProductsResource::collection($this->collection));
    }
}
