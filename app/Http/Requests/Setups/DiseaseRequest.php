<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;

class DiseaseRequest extends ApiFormRequest
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
        $id=$this->route('disease')??null;
        return [
            'name'=>'bail|'.($id?'sometimes':'required').'|'.$this->softUnique('diseases','name',$id),
            'disease_code'=>'bail|sometimes|nullable|'.$this->softUnique('diseases', 'disease_code',$id),
            'icd10_code'=>'bail|'. ($id ? 'sometimes' : 'required').'|'.$this->softUnique('diseases', 'icd10_code',$id),
            'moh_grouping_code'=>'bail|'. ($id ? 'sometimes' : 'required').'|'.$this->softUnique('diseases', 'moh_grouping_code',$id),
            'moh_ghs_grouping_id'=> 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:moh_ghs_groupings,id',
            'icd10_grouping_id'=> 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:icd10_groupings,id',
            'icd10_category_id'=> 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:icd10_categories,id',
            'illness_type_id'=> 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:illness_types,id',
            'age_group_id'=> 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:age_groups,id',
            'gender'=> 'bail|' . ($id ? 'sometimes' : 'required') . '|set:MALE,FEMALE',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
