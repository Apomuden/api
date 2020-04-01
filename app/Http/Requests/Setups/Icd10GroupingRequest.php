<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;

class Icd10GroupingRequest extends ApiFormRequest
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
        $id=$this->route('icd10grouping')??null;
        return [
            'name'=>'bail|'.($id?'sometimes':'required').'|'.$this->softUnique('icd10_groupings','name',$id),
            'status'=>'bail|'. ($id ? 'sometimes' : 'required').'|in:ACTIVE,INACTIVE'
        ];
    }
}
