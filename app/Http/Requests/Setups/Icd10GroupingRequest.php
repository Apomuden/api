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
        $id = $this->route('icd10grouping') ?? null;
        return [
            'name' => 'bail|' . ($id ? 'sometimes' : 'required') . '|' . $this->softUnique('icd10_groupings', 'name', $id),
            'icd10_grouping_code' => 'bail|sometimes|nullable|' . $this->softUnique('icd10_groupings', 'icd10_grouping_code', $id),
            'icd10_category_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:icd10_categories,id',
            'status' => 'bail|' . ($id ? 'sometimes' : 'required') . '|in:ACTIVE,INACTIVE'
        ];
    }
}
