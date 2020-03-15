<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class FamilyHistoryRequest extends ApiFormRequest
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
        $id=$this->route('familyhistory')??null;
        return [
            'name'=>'bail|'.($id?'sometimes':'required').'|'.$this->softUniqueWith('family_histories', 'name,family_history_category_id',$id),
            'family_history_category_id'=> 'bail|', ($id ? 'sometimes' : 'required') . '|exits:family_history_categories,id',
            'status'=>'bail|'. ($id ? 'sometimes' : 'required').'|in:ACTIVE,INACTIVE'
        ];
    }
}
