<?php

namespace App\Http\Resources\Pharmacy;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class RequisitionResource extends JsonResource
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
                'requested_store_id' => $this->requested_store_id,
                'issuing_store_id' => $this->issuing_store_id,
                'requisition_date' => $this->requisition_date,
                'reference_number' => $this->reference_number,
                'requested_by' => $this->requested_by,
                'approved_by' => $this->approved_by,
                'approval_date' => $this->approval_date,
                'expected_total_value' => $this->expected_total_value,
                'approved_total_value' => $this->approved_total_value,
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
            ];
        }

        return null;
    }
}
