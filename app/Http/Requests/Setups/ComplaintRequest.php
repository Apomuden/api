<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class ComplaintRequest extends ApiFormRequest
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
        $id=$this->route('complaint')??null;
        return [
            'name'=>'bail|'.($id?'sometimes':'required').'|'.$this->softUniqueWith('complaints', 'name,complaint_type_id',$id),
            'complaint_type_id'=> 'bail|', ($id ? 'sometimes' : 'required') . '|exits:complaint_types,id',
            'status'=>'bail|'. ($id ? 'sometimes' : 'required').'|in:ACTIVE,INACTIVE'
        ];
    }
}
