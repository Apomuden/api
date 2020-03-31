<?php

namespace App\Http\Resources\Accounts;

use App\Models\ReceiptItem;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReceiptItemCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ReceiptItemResource::collection($this->collection);
    }
}
