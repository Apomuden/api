<?php

namespace App\Http\Requests\Clinic;

use App\Http\Requests\ApiFormRequest;
use App\Models\Clinic;
use App\Models\HospitalService;
use App\Models\Service;
use App\Repositories\RepositoryEloquent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClinicServiceRequest extends ApiFormRequest
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
        $id=$this->route('clinicservice')??null;
        $repository=new RepositoryEloquent(new HospitalService);
        $consultation_service=$repository
        ->findWhere(['name'=>'Consultation'])
        ->orWhere('name','Consultation service')->first();
        return [
            'clinic_id'=>['bail',($id?'sometimes':'required'),'integer', Rule::exists('clinics', 'id')],
            'service_id'=> ['bail', ($id ? 'sometimes' : 'required'), 'integer',
               Rule::exists('services', 'id')->where(function($query) use($consultation_service){
                  $query->where('hospital_service_id',$consultation_service->id);
               })
             ],
            'billing_cycle_id'=> ['bail',($id ? 'sometimes' : 'required'), 'integer', Rule::exists('billing_cycles', 'id')],
            'billing_duration'=> 'bail|'.($id ? 'sometimes' : 'required').'|integer|min:1'
        ];
    }
}
