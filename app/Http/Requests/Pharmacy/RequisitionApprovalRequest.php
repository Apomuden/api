<?php

namespace App\Http\Requests\Pharmacy;

use App\Http\Requests\ApiFormRequest;

class RequisitionApprovalRequest extends ApiFormRequest
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
        $id = $this->route('approval')??null; //TODO: Change the route param from dummyparam

        return [
            'reference_number'=>'bail|'.($id?'sometimes':'required').'|exists:requisitions,reference_number',
            'requisition_id'=>'bail|'.($id?'sometimes':'required').'|exists:requisitions,id',
            'requested_store_id' => 'bail|sometimes|exists:stores,id',
            'issuing_store_id' => 'bail|sometimes|exists:stores,id',
            'requisition_date' => 'bail|sometimes|date',
            'approval_date' => 'bail|sometimes|date',
            'expected_total_value' => 'bail|sometimes|numeric|min:0',
            'approved_total_value' => 'bail|sometimes|numeric|min:0',
            'status'=>'bail|sometimes|in:PENDING,APPROVED,CANCELLED,SUSPENDED',
            'requested_by'=>'bail|sometimes|exists:users,id',
            'approved_by'=>'bail|sometimes|exists:users,id',
            'products'=>'bail|'.($id?'sometimes':'required').'|array',
            'products.*.product_id'=>'bail|'.($id?'sometimes':'required').'|exists:products,id',
            'products.*.batch_number' =>'bail|sometimes|string',
            'products.*.expiry_date' =>'bail|sometimes|date',
            'products.*.unit_of_measurement' =>'bail|sometimes|string',
            'products.*.issuer_quantity_at_hand' =>'bail|optional|numeric|min:0',
            'products.*.approved_quantity' =>'bail|'.($id?'sometimes':'required').'|numeric|min:0',
            'products.*.unit_cost' =>'bail|sometimes|numeric|min:0',
            'products.*.reason' =>'bail|sometimes|string'
        ];
    }
}
