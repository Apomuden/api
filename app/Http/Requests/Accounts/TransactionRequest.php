<?php

namespace App\Http\Requests\Accounts;

use App\Http\Requests\ApiFormRequest;

class TransactionRequest extends ApiFormRequest
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
        return [
            'patient_id'=>'bail|required|exists:patients,id',
            'patient_status'=>'bail|required|in:IN-PATIENT,OUT-PATIENT,WALK-IN',
            'services'=>'bail|required|array',
            'services.*.transaction_update_id'=>'bail|required|string',
            'services.*.status'=>'bail|sometimes|in:PENDING,PART-PAYMENT,FULL-PAYMENT,CANCELLED,ABSCOND,REFUNDED',
            'outstanding_bill'=>'bail|numeric|min:0',
            'total_bill'=>'bail|required|numeric|min:0',
            'amount_paid'=>'bail|required|numeric|min:0'
        ];
    }
}
