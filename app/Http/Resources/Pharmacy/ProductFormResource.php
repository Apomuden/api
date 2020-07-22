<?php

namespace App\Http\Resources\Pharmacy;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'product_type_name' => $this->product_type->name ?? null,
            'product_type_id' => $this->product_type->id ?? null,
            'status' => $this->status,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
        ];
    }
}
