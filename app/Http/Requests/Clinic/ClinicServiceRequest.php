<?php

namespace App\Http\Requests\Clinic;

use App\Http\Requests\ApiFormRequest;
use App\Models\Clinic;
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
        $repository=new RepositoryEloquent(new Clinic);
        $clinic=$repository->find((request()->input('clinic_id')??null));
        return [
            'clinic_id'=>['bail',($id?'sometime':'required'),'integer', Rule::exists('clinics', 'id')],
            'consultation_service_id'=>['bail',($id ? 'sometime' : 'required'),'integer',
             Rule::exists('service_subcategories', 'id')->where(function($query) use($clinic){
                $query->where('service_category_id',$clinic->main_clinic_id);
             })],
            'billing_cycle_id'=> ['bail',($id ? 'sometime' : 'required'), 'integer', Rule::exists('billing_cycles', 'id')],
            'billing_duration'=> 'bail|'.($id ? 'sometime' : 'required').'|integer|min:1'
        ];
    }
}
