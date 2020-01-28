<?php
//This is Request is for the current logged in user
namespace App\Http\Requests\Registrations;

use App\Http\Requests\ApiFormRequest;
use App\Models\Hospital;
use App\Models\IdType;
use App\Models\Relationship;
use App\Models\SponsorshipPolicy;
use App\Repositories\HospitalEloquent;
use App\Repositories\RepositoryEloquent;
use Illuminate\Validation\Rule;

class PatientSponsorRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $id = $this->route('patientsponsor') ?? null;
        $billing_sponsor_id=request()->input('billing_sponsor_id')??null;
        $sponsorship_policy_id=request()->input('sponsorship_policy_id')??null;
        $company_id=request()->input('company_id')??null;
        $benefit_type=request()->input('benefit_type')??null;

        $policiesCount=0;
        if($billing_sponsor_id){
            $repository = new RepositoryEloquent(new SponsorshipPolicy);
            $policiesCount = $repository->findWhere(['billing_sponsor_id'=>$billing_sponsor_id])->count();
        }

        $data= [
            'patient_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|exists:patients,id',
            'billing_sponsor_id' => 'bail|'. ($id|| $sponsorship_policy_id ? 'sometimes|nullable' : 'required'). '|integer|exists:billing_sponsors,id',
            'sponsorship_policy_id' => 'bail|' . ($id || !$policiesCount ? 'sometimes|nullable' : 'required') . '|integer|exists:sponsorship_policies,id',
            'priority' => 'bail|sometimes|numeric|min:1',
            'member_id' => 'bail|'. ($id  ? 'sometimes|nullable' : 'required').'|'.($benefit_type=='BABY'? $this->softUniqueWith('patient_sponsors', 'member_id,patient_id', $id): $this->softUnique('patient_sponsors', 'member_id',$id)),
            'card_serial_no' => 'bail|sometimes|nullable|'.($benefit_type=='BABY'? $this->softUniqueWith('patient_sponsors', 'card_serial_no,patient_id', $id): $this->softUnique('patient_sponsors', 'card_serial_no', $id)),
            'company_id' => 'bail|sometimes|nullable|exists:companies,id',
            'staff_name' => 'bail|'.($id||!$company_id?'sometimes|nullable':'required').'|string',
            'staff_id' => 'bail|' . ($id || !$company_id ? 'sometimes|nullable' : 'required') . '|min:2',
            'benefit_type' => 'bail|' . ($id ? 'sometimes' : 'required') . '|in:SELF,DEPENDANT,BABY',
            'relation_id' => [
                'bail',
                !($benefit_type=='SELF'||$id)?'required':'sometimes',
                !($benefit_type=='SELF'||$id)?'required':'nullable',
                $benefit_type=='BABY'? Rule::exists('relationships', 'id')->where(function ($query) {
                    $query->where('name','mother');
                }) : Rule::exists('relationships', 'id'),
            ],
            'issued_date' => 'bail|'. ($id ? 'sometimes' : 'required').'|date',
            'expiry_date' => 'bail|'. ($id ? 'sometimes' : 'required').'|date',
            'status' => 'bail|sometimes|string|in:ACTIVE,INACTIVE,TERMINATED,BLACKLISTED'
        ];

        return $data;
    }
}
