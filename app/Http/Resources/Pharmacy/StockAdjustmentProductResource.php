<?php

namespace App\Http\Resources\Pharmacy;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class StockAdjustmentProductResource extends JsonResource
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
            $product = $this->product??null;
            return [
                'id' => $this->id,
                'product_id' => $this->product_id,
                'batch_number' => $this->batch_number,
                'expiry_date' => $this->expiry_date,
                'unit_of_measurement' => $this->unit_of_measurement,
                'quantity_at_hand' => $this->quantity_at_hand,
                'adjusted_quantity' => $this->adjusted_quantity,
                'approved_quantity' => $this->approved_quantity,
                'unit_cost' => $this->unit_cost,
                'expected_value' => $this->expected_value,
                'approved_expected_value' => $this->approved_expected_value,
                'reference_number' => $this->reference_number,
                'adjustment_reason' => $this->adjustment_reason,
                'adjustment_type' => $this->adjustment_type,
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),

            ];
        }

        return NULL;
    }
}
