<?php

namespace App\Http\Resources\Pharmacy;

use App\Http\Controllers\Pharmacy\StockAdjustmentProductController;
use App\Http\Helpers\DateHelper;
use App\Models\StockAdjustmentProduct;
use Illuminate\Http\Resources\Json\JsonResource;

class StockAdjustmentResource extends JsonResource
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
            $store = $this->store ?? null;
            $stock_adjustment_product = $this->stock_adjustment_product ?? null;
            $userRequested = $this->user_requested;
            $userApproved = $this->user_approved;
            $userApprovedName = null;
            if ($userApproved) {
                $userApprovedName = trim(sprintf("%s %s %s", $userApproved->firstname, $userApproved->middlename??"", $userApproved->surname));
            }
            $userRequestedName = trim(sprintf("%s %s %s", $userRequested->firstname, $userRequested->middlename??"", $userRequested->surname));
            return [
                'id' => $this->id,
                'adjustment_type' => $this->adjustment_type,
                'store_id' => $this->store_id,
                'store_name' => $store->name ?? null,
                'reference_number' => $this->reference_number,
                'description' => $this->description,
                'status' => $this->status,
                'requested_by' => $this->requested_by??null,
                'requested_by_name' => $userRequestedName,
                'approved_by_name' => $userApprovedName,
                'approved_by' => $this->approved_by??null,
                'adjustment_date' => $this->adjustment_date,
                'approval_date' => $this->approval_date,
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
            ];
        }

        return null;
    }
}
