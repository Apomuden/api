<?php

namespace App\Http\Requests\Pharmacy;

use App\Http\Requests\ApiFormRequest;

class StockAdjustmentApprovalRequest extends ApiFormRequest
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
        $id = $this->route('approval')??null;
        return [
            'stock_adjustment_id'=>'bail|'.($id?'sometimes':'required').'|exists:stock_adjustments,id',
            'adjustment_type'=>'bail|sometimes|in:OPERATIONAL,OPENING',
            'store_id'=>'bail|'.($id?'sometimes':'required').'|exists:stores,id',
            'reference_number'=>'bail|'.($id?'sometimes':'required').'|exists:stock_adjustments,reference_number',
            'status'=>'bail|sometimes|in:PENDING,APPROVED,CANCELLED,SUSPENDED',
            'approval_date'=>'bail|sometimes|date',
            'products'=>'bail|required|array',
            'products.*.id'=>'bail|'.($id?'sometimes':'required').'|exists:stock_adjustment_products,id',
            'products.*.product_id'=>'bail|'.($id?'sometimes':'required').'|exists:products,id',
            'products.*.approved_quantity' =>'bail|'.($id?'sometimes':'required').'|numeric|min:0',
            'products.*.adjustment_type' =>'bail|required|in:INCREASE,DECREASE',
        ];
    }
}
