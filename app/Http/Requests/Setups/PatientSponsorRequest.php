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
        $billing_sponsor = $billing_sponsor_id ? (BillingSponsor::find($billing_sponsor_id)) : null;

        $validator_values=['sponsorship_type_name'=>null, 'sponsorship_type_id'=>null];
        if ($billing_sponsor) {
            $validator_values['sponsorship_type_id'] = $billing_sponsor->sponsorship_type_id??null;
            $sponsorship_types = $validator_values['sponsorship_type_id'] ? (SponsorshipType::find($validator_values['sponsorship_type_id'])) : null;
            if($sponsorship_types) {
                $validator_values['sponsorship_type_name'] = strtolower($sponsorship_types->name??null);
            }
            unset($sponsorship_types);
        }

        return [
            'patient_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:patients,id',
            'billing_sponsor_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:billing_sponsors,id',

            'sponsorship_policy_id'=>'bail|'.(($validator_values['sponsorship_type_name'] === 'private insurance' && !$id) ? 'required':'sometimes|nullable').'
                                     |integer|exists:sponsorship_policies,id',

            'relation_id'=>'bail|'.($id?'sometimes':'required_if:benefit_type,DEPENDANT').'|integer|exists:relationships,id',

            'staff_name'=>'bail|'.((($validator_values['sponsorship_type_name'] === 'government insurance'
                    || $validator_values['sponsorship_type_name']==='private insurance') && $this->benefit_type==='DEPENDANT' && !$id) ? 'required':'sometimes|nullable').'|string',

            'staff_id'=>'bail|'.((($validator_values['sponsorship_type_name'] === 'government company'
                    || $validator_values['sponsorship_type_name']==='private company')  && !$id) ? 'required':'sometimes|nullable').'|string',

            'member_id'=>'bail|'.((($validator_values['sponsorship_type_name'] === 'government insurance'
                    || $validator_values['sponsorship_type_name']==='private insurance') && !$id) ? 'required':'sometimes|nullable').'|string',

            'card_serial_no'=>'bail|'.((($validator_values['sponsorship_type_name'] === 'government insurance') && !$id) ? 'required':'sometimes|nullable').'|unique',
            'user_id'=>'bail|sometimes|nullable|exists:users,id',
            'priority'=>'bail|sometimes|nullable|integer|min:0',
            'issued_date'=>'bail|'.(($validator_values['sponsorship_type_name'] === 'patient' && !$id)?'sometimes':'required').'|date',
            'expiry_date'=>'bail|sometimes|nullable|date',
            'benefit_type'=>'bail|sometimes|in:SELF,DEPENDANT,BABY',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
