<?php

namespace App\Http\Requests\Accounts;

use App\Http\Requests\ApiFormRequest;

class RefundRequest extends ApiFormRequest
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
        $id = $this->route('refund')??null;
        return [
            //'patient_id'=>'bail|'..'|integer|exists:patients,id',
            'receipt_number'=>'bail|'.($id?'sometimes':'required').'|exists:ereceipts,receipt_number',
            'reason'=>'bail|'.($id?'sometimes':'required'),
            'refund_amount'=>'bail|sometimes|nullable|numeric|min:0',
        ];
    }
}
