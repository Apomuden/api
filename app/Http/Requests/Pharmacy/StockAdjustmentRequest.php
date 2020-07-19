<?php

namespace App\Http\Requests\Pharmacy;

use App\Http\Requests\ApiFormRequest;

class StockAdjustmentRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('stockadjustment')??null;
        return [
            'adjustment_type'=>'bail|sometimes|in:OPERATIONAL,OPENING',
            'store_id'=>'bail|'.($id?'sometimes':'required').'|exists:stores,id',
            'description'=>'bail|sometimes|string',
            'status'=>'bail|sometimes|in:PENDING,APPROVED,CANCELLED,SUSPENDED',
            'requested_by'=>'bail|sometimes|exists:users,id',
            'approved_by'=>'bail|sometimes|exists:users,id',
            'adjustment_date'=>'bail|sometimes|date',
            'products'=>'bail|'.($id?'sometimes':'required').'|array',
            'products.*.product_id'=>'bail|'.($id?'sometimes':'required').'|exists:products,id',
            'products.*.batch_number' =>'bail|'.($id?'sometimes':'required').'|string',
            'products.*.expiry_date' =>'bail|sometimes|date',
            'products.*.unit_of_measurement' =>'bail|'.($id?'sometimes':'required').'|string',
            'products.*.quantity_at_hand' =>'bail|'.($id?'sometimes':'required').'|numeric|min:0',
            'products.*.adjusted_quantity' =>'bail|'.($id?'sometimes':'required').'|numeric|min:0',
            'products.*.approved_quantity' =>'bail|sometimes|numeric|min:0',
            'products.*.unit_cost' =>'bail|'.($id?'sometimes':'required').'|numeric|min:0',
            'products.*.adjustment_reason' =>'bail|'.($id?'sometimes':'required').'|string',
            'products.*.adjustment_type' =>'bail|sometimes|in:INCREASE,DECREASE',
        ];
    }
}
