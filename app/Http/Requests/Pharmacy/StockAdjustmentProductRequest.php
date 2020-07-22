<?php

namespace App\Http\Requests\Pharmacy;

use App\Http\Requests\ApiFormRequest;

class StockAdjustmentProductRequest extends ApiFormRequest
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
        $id = $this->route('stockadjustmentproduct') ?? null;
        return [
            'product_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:products,id',
            'batch_number' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string',
            'expiry_date' => 'bail|sometimes|date',
            'unit_of_measurement' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string',
            'quantity_at_hand' => 'bail|' . ($id ? 'sometimes' : 'required') . '|numeric|min:0',
            'adjusted_quantity' => 'bail|' . ($id ? 'sometimes' : 'required') . '|numeric|min:0',
            'approved_quantity' => 'bail|' . ($id ? 'sometimes' : 'required') . '|numeric|min:0',
            'unit_cost' => 'bail|' . ($id ? 'sometimes' : 'required') . '|numeric|min:0',
            'adjustment_reason' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string',
            'adjustment_type' => 'bail|sometimes|in:INCREASE,DECREASE'
        ];
    }
}
