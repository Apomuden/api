<?php

namespace App\Http\Resources\Accounts;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DiscountCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return DiscountResource::collection($this->collection);
    }
}
