<?php

namespace App\Http\Requests\Pharmacy;

use App\Http\Requests\ApiFormRequest;

class RequisitionRequest extends ApiFormRequest
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
        $id = $this->route('requisition') ?? null; //TODO: Change the route param from dummyparam

        return [
            'requested_store_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:stores,id',
            'issuing_store_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:stores,id',
            'requisition_date' => 'bail|sometimes|date',
            'approval_date' => 'bail|sometimes|date',
            'expected_total_value' => 'bail|sometimes|numeric|min:0',
            'approved_total_value' => 'bail|sometimes|numeric|min:0',
            'status' => 'bail|sometimes|in:PENDING,APPROVED,CANCELLED,SUSPENDED',
            'requested_by' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:users,id',
            'approved_by' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:users,id',
            'products' => 'bail|' . ($id ? 'sometimes' : 'required') . '|array',
            'products.*.product_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:products,id',
            'products.*.batch_number' => 'bail|sometimes|string',
            'products.*.expiry_date' => 'bail|sometimes|date',
            'products.*.unit_of_measurement' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string',
            'products.*.requester_quantity_at_hand' => 'bail|' . ($id ? 'sometimes' : 'required') . '|numeric|min:0',
            'products.*.issuer_quantity_at_hand' => 'bail|sometimes|numeric|min:0',
            'products.*.requested_quantity' => 'bail|' . ($id ? 'sometimes' : 'required') . '|numeric|min:0',
            'products.*.approved_quantity' => 'bail|sometimes|numeric|min:0',
            'products.*.unit_cost' => 'bail|' . ($id ? 'sometimes' : 'required') . '|numeric|min:0',
            'products.*.reason' => 'bail|sometimes|string'
        ];
    }
}
