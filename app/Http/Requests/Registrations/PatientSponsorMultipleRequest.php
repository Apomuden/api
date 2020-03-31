<?php
//This is Request is for the current logged in user
namespace App\Http\Requests\Registrations;

use App\Http\Requests\ApiFormRequest;

use Illuminate\Validation\Rule;

class PatientSponsorMultipleRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $data= [
            'patient_id' => 'bail|required|integer|exists:patients,id',
            'sponsors'=>'bail|array',
            'sponsors.*.billing_sponsor_id'=> 'bail|required_without:sponsorship_policy_id|distinct|integer|exists:billing_sponsors,id',
            'sponsors.*.sponsorship_policy_id' => 'bail|sometimes|nullable|integer|exists:sponsorship_policies,id',
            'sponsors.*.priority' => 'bail|sometimes|numeric|min:1',
            'sponsors.*.member_id' => 'bail|required',
            'sponsors.*.card_serial_no' => 'bail|sometimes|nullable',
            'sponsors.*.company_id' => 'bail|sometimes|nullable|exists:companies,id',
            'sponsors.*.staff_name' => 'bail|required_with:sponsors.*.company_id|string',
            'sponsors.*.staff_id' => 'bail|required_with:sponsors.*.company_id|min:2',
            'sponsors.*.benefit_type' => 'bail|required|in:SELF,DEPENDANT,BABY',
            'sponsors.*.relation_id' => [
                'bail',
                'sometimes','nullable',Rule::exists('relationships', 'id'),
            ],
            'sponsors.*.issued_date' => 'bail|required|date',
            'sponsors.*.expiry_date' => 'bail|required|date',
            'sponsors.*.status' => 'bail|sometimes|string|in:ACTIVE,INACTIVE,TERMINATED,BLACKLISTED'
        ];

        return $data;
    }
}
