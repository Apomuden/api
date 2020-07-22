<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;

class MohGhsGroupingRequest extends ApiFormRequest
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
        $id = $this->route('mohghsgrouping') ?? null;
        return [
            'name' => 'bail|' . ($id ? 'sometimes' : 'required') . '|' . $this->softUnique('moh_ghs_groupings', 'name', $id),
            'moh_grouping_code' => 'bail|sometimes|nullable|' . $this->softUnique('moh_ghs_groupings', 'moh_grouping_code', $id),
            'status' => 'bail|' . ($id ? 'sometimes' : 'required') . '|in:ACTIVE,INACTIVE'
        ];
    }
}
