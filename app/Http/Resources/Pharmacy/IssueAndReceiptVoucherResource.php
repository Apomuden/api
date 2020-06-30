<?php

namespace App\Http\Resources\Pharmacy;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class IssueAndReceiptVoucherResource extends JsonResource
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
                'issued_by' => $this->issued_by,
                'issuing_store_id' => $this->issuing_store_id,
                'requisition_reference_number' => $this->requisition_reference_number,
                'requisition_id' => $this->requisition_id,
                'issued_voucher_number' => $this->issued_voucher_number,
                'issued_total_value' => $this->issued_total_value,
                'date_issued' => $this->date_issued,
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
            ];
        }

        return NULL;
    }
}
