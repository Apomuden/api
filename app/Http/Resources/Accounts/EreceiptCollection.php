<?php

namespace App\Http\Resources\Accounts;

use App\Models\Ereceipt;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EreceiptCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return EreceiptResource::collection($this->collection);
    }
}
