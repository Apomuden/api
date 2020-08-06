<?php

namespace App\Http\Requests\Pharmacy;

use App\Http\Requests\ApiFormRequest;

class StockRequest extends ApiFormRequest
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
        $id = $this->route('stock')??null; //TODO: Change the route param from dummyparam

        return [
            'store_id' => 'bail|'.($id?'sometimes':'required').'|exists:store,id',
            'product_id' => 'bail|'.($id?'sometimes':'required').'|exists:products,id|'.$this->softUniqueWith('stocks','store_id,product_id,deleted_at', $id),
            'batch_number' => 'bail|sometimes|',
            'expiry_date' => 'bail|sometimes|date',
            'unit_of_measurement' => 'bail|sometimes|string',
            'opening_stock_quantity' => 'bail|'.($id?'sometimes':'required').'|integer|min:0',
            'original_quantity' => 'bail|'.($id?'sometimes':'required').'|integer|min:0',
            'quantity_remaining' => 'bail|sometimes|integer|min:0',
            'adjustment_reason' => 'bail|sometimes|string',
            'status' => 'bail|sometimes|in:ACTIVE.INACTIVE'
        ];
    }
}
