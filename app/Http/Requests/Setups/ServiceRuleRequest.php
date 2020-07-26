<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;

class ServiceRuleRequest extends ApiFormRequest
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
        $id=$this->route('servicerule')??null;
        return [
            'name'=>'bail|'.($id?'sometimes|nullable':'required').'|'.$this->softUnique('service_rules','name',$id),
            'patient_status'=>'bail|'. 'sometimes|nullable'. '|set:IN-PATIENT,OUT-PATIENT,WALK-IN',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
