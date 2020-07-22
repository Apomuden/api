<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;

class AgeCategoryRequest extends ApiFormRequest
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
        $id = $this->route('agecategory') ?? null;
        return [
            'description' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|' . $this->softUniqueWith('age_categories', 'description,age_classification_id', $id),
            'age_classification_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|exists:age_classifications,id',
            'age_group_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|exists:age_groups,id',
            'min_unit' => 'bail|sometimes|in:DAY,MONTH,YEAR',
            'max_unit' => 'bail|sometimes|in:DAY,MONTH,YEAR',
            'min_comparator' => 'bail|sometimes|in:>,>=,=',
            'max_comparator' => 'bail|sometimes|in:<,<=',
            'max_age' => 'bail|sometimes|nullable|min:1',
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
