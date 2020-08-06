<?php

namespace App\Http\Resources\Pharmacy;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
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
                'store_id' => $this->store_id,
                'store_name' => $this->store->name??null,
                'product_id' => $this->product_id,
                'products' => $this->product??null,
                'batch_number' => $this->batch_number,
                'expiry_date' => $this->expiry_date,
                'unit_of_measurement' => $this->unit_of_measurement,
                'opening_stock_quantity' => $this->opening_stock_quantity,
                'original_quantity' => $this->original_quantity,
                'quantity_remaining' => $this->quantity_remaining,
                'adjustment_reason' => $this->adjustment_reason,
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
            ];
        }

        return NULL;
    }
}
