<?php

namespace App\Http\Requests\Accounts;

use App\Http\Requests\ApiFormRequest;
use App\Models\SponsorshipType;
use App\Repositories\RepositoryEloquent;

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
        $sponsorship_type_id = (request()->input('sponsorship_type_id')) ?? null;
        $sponsorship_type = null;
        if ($sponsorship_type_id) {
            $repository = new RepositoryEloquent(new SponsorshipType);
            $sponsorship_type = $repository->find($sponsorship_type_id)->name??null;
            $sponsorship_type = $sponsorship_type?strtolower($sponsorship_type):null;
        }
        return [
            'patient_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:patients,id',
            'patient_status'=>'bail|sometimes|in:IN-PATIENT,OUT-PATIENT,WALK-IN',
            'funding_type_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:funding_types,id',
            'sponsorship_type_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:sponsorship_types,id',
            'billing_sponsor_id'=>'bail|'.($id || ($sponsorship_type=='patient' || $sponsorship_type=='government insurance') ?'sometimes|nullable':'required').'|integer|exists:billing_sponsors,id',
            'patient_sponsor_id'=>'bail|'.($id || ($sponsorship_type=='patient' || $sponsorship_type=='government insurance') ?'sometimes|nullable':'required').'|integer|exists:patient_sponsors,id',
            'receipt_number'=>'bail|'.($id?'sometimes':'required').'|exists:ereceipts,receipt_number',
            'reason'=>'bail|'.($id?'sometimes':'required'),
            'refund_amount'=>'bail|sometimes|nullable|numeric|min:0',
        ];
    }
}
