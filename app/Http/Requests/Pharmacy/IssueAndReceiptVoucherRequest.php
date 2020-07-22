<?php

namespace App\Http\Requests\Pharmacy;

use App\Http\Requests\ApiFormRequest;

class IssueAndReceiptVoucherRequest extends ApiFormRequest
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
        $id = $this->route('issuereceiptvoucher') ?? null; //TODO: Change the route param from dummyparam

        return [
            'id' => 'bail',
            'issuing_store_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:stores,id',
            'requisition_reference_number' => 'bail' . ($id ? 'sometimes' : 'required') . '|exists:requisitions,reference_number',
            'requisition_id' => 'bail' . ($id ? 'sometimes' : 'required') . '|exists:stores,id',
            'issued_voucher_number' => 'bail|sometimes|string',
            'issued_total_value' => 'bail|' . ($id ? 'sometimes' : 'required') . '|numeric|min:0',
            'issued_quantity' => 'bail|' . ($id ? 'sometimes' : 'required') . '|numeric|min:0',
            'issued_value' => 'bail|' . ($id ? 'sometimes' : 'required') . '|numeric|min:0',
            'date_issued' => 'bail|sometimes|date'
        ];
    }
}
