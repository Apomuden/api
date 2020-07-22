<?php

namespace App\Http\Resources\Pharmacy;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $store_activity = $this->store_activity ?? null;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'purchasing_from_suppliers' => $store_activity->purchasing_from_suppliers ?? null,
            'receiving_from_suppliers' => $store_activity->receiving_from_suppliers ?? null,
            'issuing_requested_product' => $store_activity->issuing_requested_product ?? null,
            'requesting_products_from_stores' => $store_activity->requesting_products_from_stores ?? null,
            'receiving_issued_products' => $store_activity->receiving_issued_products ?? null,
            'direct_engagement_with_patient' => $store_activity->direct_engagement_with_patient ?? null,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
        ];
    }
}
