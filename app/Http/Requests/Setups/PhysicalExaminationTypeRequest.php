<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;

class PhysicalExaminationTypeRequest extends ApiFormRequest
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
        $id = $this->route('physicalexaminationcategory') ?? null;
        return [
            'name' => 'bail|' . ($id ? 'sometimes' : 'required') . '|' . $this->softUniqueWith('physical_examination_types', 'name,category_id', $id),
            'category_id'=> 'bail|exists:physical_examination_categories,id',
            'status' => 'bail|' . ($id ? 'sometimes' : 'required') . '|in:ACTIVE,INACTIVE'
        ];
    }
}
