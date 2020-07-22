<?php

namespace App\Http\Resources\Pharmacy;

use App\Http\Resources\Helpers\PaginatedCollectionHelper;

class StockAdjustmentCollection extends PaginatedCollectionHelper
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @param null $coll
     * @return array
     */
    public function toArray($request, $coll = null)
    {
        return parent::toArray($request, StockAdjustmentResource::collection($this->collection));
    }
}
