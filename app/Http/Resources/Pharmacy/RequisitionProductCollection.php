<?php

namespace App\Http\Resources\Pharmacy;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RequisitionProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return RequisitionProductResource::collection($this->collection);
    }
}
