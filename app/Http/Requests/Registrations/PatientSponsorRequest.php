<?php

namespace App\Http\Requests\Registrations;

use App\Http\Requests\ApiFormRequest;
use App\Models\BillingSponsor;
use App\Models\SponsorshipPolicy;
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
        $billing_sponsor_id=request()->input('billing_sponsor_id')??null;
        //$sponsorship_policy_id=request()->input('sponsorship_policy_id')??null;
        //$company_id=request()->input('company_id')??null;
        $benefit_type=request()->input('benefit_type')??null;
        $billing_sponsor = $billing_sponsor_id ? (BillingSponsor::find($billing_sponsor_id)) : null;

        //$policiesCount=0;
        $validator_values=['sponsorship_type_name'=>null, 'sponsorship_type_id'=>null];
        if ($billing_sponsor) {
            $validator_values['sponsorship_type_id'] = $billing_sponsor->sponsorship_type_id??null;
            $sponsorship_types = $validator_values['sponsorship_type_id'] ? (SponsorshipType::find($validator_values['sponsorship_type_id'])) : null;
            if($sponsorship_types) {
                $validator_values['sponsorship_type_name'] = strtolower($sponsorship_types->name??null);
            }

            /*$repository = new RepositoryEloquent(new SponsorshipPolicy);
            $policiesCount = $repository->findWhere(['billing_sponsor_id'=>$billing_sponsor_id])->count();*/
            unset($sponsorship_types);
        }

        return [
            'patient_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:patients,id',
            'sponsorship_policy_id'=>'bail|sometimes|nullable|integer|exists:sponsorship_policies,id',
            'billing_sponsor_id'=>'bail|'.($id?'sometimes|nullable':'required').'|integer|exists:billing_sponsors,id',

            'company_id' => 'bail|sometimes|nullable|exists:companies,id',

            'relation_id'=>'bail|'.($id?'sometimes|nullable':'required_if:benefit_type,DEPENDANT').'|integer|exists:relationships,id',

            'staff_name'=>'bail|'.((($validator_values['sponsorship_type_name'] === 'government company'
                        || $validator_values['sponsorship_type_name']==='private company') && !$id) ? 'required_if:benefit_type,DEPENDANT':'sometimes|nullable').'|string',

            'staff_id'=>'bail|'.((($validator_values['sponsorship_type_name'] === 'government company'
                        || $validator_values['sponsorship_type_name']==='private company')  && !$id) ? 'required':'sometimes|nullable').'|string',

            'member_id'=>'bail|'.((($validator_values['sponsorship_type_name'] === 'government insurance'
                        || $validator_values['sponsorship_type_name']==='private insurance') && !$id) ? 'required':'sometimes|nullable').'|string|'.($benefit_type == 'BABY'? $this->softUniqueWith('patient_sponsors', 'member_id,patient_id', $id): $this->softUnique('patient_sponsors', 'member_id',$id)),

            'card_serial_no'=>'bail|'.((($validator_values['sponsorship_type_name'] === 'government insurance') && !$id) ? 'required':'sometimes|nullable').'|unique|'.($benefit_type=='BABY'? $this->softUniqueWith('patient_sponsors', 'card_serial_no,patient_id', $id): $this->softUnique('patient_sponsors', 'card_serial_no', $id)),
            'user_id'=>'bail|sometimes|nullable|exists:users,id',
            'priority'=>'bail|sometimes|nullable|numeric|min:1',
            'issued_date'=>'bail|sometimes|nullable|date',
            'expiry_date'=>'bail|sometimes|nullable|date',
            'benefit_type'=>'bail|sometimes|in:SELF,DEPENDANT,BABY',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE,TERMINATED,BLACKLISTED'
        ];
    }
}
