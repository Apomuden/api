<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;
use App\Models\BillingSponsor;
use App\Models\SponsorshipType;
use App\Repositories\RepositoryEloquent;

class PatientSponsorRequest extends ApiFormRequest
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
        $id=$this->route('patientsponsor')??null;
        $billing_sponsor_id = $this->billing_sponsor_id ?? null;
        $billing_sponsor = BillingSponsor::find($billing_sponsor_id);

        /*
        $sponsorship_type=['name'=>null];
        if ($billing_sponsor) {
            $sponsorship_type = SponsorshipType::find($billing_sponsor->sponsorship_type_id);
        }
        */
        return [
            'patient_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:patients,id',
            'billing_sponsor_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:billing_sponsors,id',
            'sponsorship_policy_id'=>'bail|sometimes|nullable|integer|exists:sponsorship_policies,id',
            'relation_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:relationships,id',
            'staff_name'=>'bail|sometimes|nullable|string',
            'staff_id'=>'bail|sometimes|nullable|string',
            'member_id'=>'bail|sometimes|nullable|string',
            'card_serial_no'=>'bail|sometimes|unique',
            'user_id'=>'bail|sometimes|nullable|exists:users,id',
            'priority'=>'bail|sometimes|nullable|integer|min:0',
            'issued_date'=>'bail|'.($id?'sometimes':'required').'|date',
            'expiry_date'=>'bail|sometimes|nullable|date',
            'priority'=>'bail|sometimes|nullable|',
            'benefit_type'=>'bail|sometimes|in:SELF,DEPENDANT,BABY',
            'name' => 'bail|'.($id?'sometimes':'required').'|string|'.$this->softUnique('sponsorship_types','name',$id),
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
