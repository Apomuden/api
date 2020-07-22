<?php

namespace App\Http\Resources\Pharmacy;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $store = $this->store??null;
        return [
            'id'=>$this->id,
            'store_id'=>$store->id??null,
            'store_name'=>$store->name??null,
            'purchasing_from_suppliers'=>$this->purchasing_from_suppliers??null,
            'receiving_from_suppliers'=>$this->receiving_from_suppliers??null,
            'issuing_requested_product'=>$this->issuing_requested_product??null,
            'requesting_products_from_stores'=>$this->requesting_products_from_stores??null,
            'receiving_issued_products'=>$this->receiving_issued_products??null,
            'direct_engagement_with_patient'=>$this->direct_engagement_with_patient??null,
            'created_at'=>DateHelper::toDisplayDateTime($this->created_at)??null,
            'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at)??null
        ];
    }
}
