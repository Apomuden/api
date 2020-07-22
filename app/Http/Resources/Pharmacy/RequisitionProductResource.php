<?php

namespace App\Http\Resources\Pharmacy;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class RequisitionProductResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (isset($this->id)) {
            return [
                'id' => $this->id,
                'product_id' => $this->product_id,
                'brand_name' => $product->brand_name ?? null,
                'generic_name' => $product->generic_name ?? null,
                'batch_number' => $this->batch_number,
                'expiry_date' => $this->expiry_date,
                'unit_of_measurement' => $this->unit_of_measurement,
                'issuer_quantity_at_hand' => $this->issuer_quantity_at_hand,
                'requester_quantity_at_hand' => $this->requester_quantity_at_hand,
                'requested_quantity' => $this->requested_quantity,
                'approved_quantity' => $this->approved_quantity,
                'unit_cost' => $this->unit_cost,
                'expected_value' => $this->expected_value,
                'approved_expected_value' => $this->approved_expected_value,
                'reference_number' => $this->reference_number,
                'reason' => $this->reason,
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
            ];
        }

        return null;
    }
}
