<?php

namespace App\Http\Requests\Lab;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class LabSampleTypeRequest extends ApiFormRequest
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
        $id=$this->route('sampletype');
        return [
            'name'=>'bail|string|'.$this->softUnique('lab_sample_types','name',$id),
            'prefix'=>'bail|string|max:3|'.$this->softUnique('lab_sample_types', 'prefix',$id),
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
