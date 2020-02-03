<?php

namespace App\Http\Requests\Registrations;

use App\Models\BillingSponsor;
use App\Models\SponsorshipType;
use Illuminate\Foundation\Http\FormRequest;

class SponsorshipRenewalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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

            'member_id'=>'bail|'.((($validator_values['sponsorship_type_name'] === 'government insurance'
                        || $validator_values['sponsorship_type_name']==='private insurance') && !$id) ? 'required':'sometimes|nullable').'|string',

            'card_serial_no'=>'bail|'.((($validator_values['sponsorship_type_name'] === 'government insurance') && !$id) ? 'required':'sometimes|nullable').'|unique',
            'renewal_start_date'=>'bail|sometimes|nullable|date',
            'renewal_end_date'=>'bail|sometimes|nullable|date',
        ];
    }
}
