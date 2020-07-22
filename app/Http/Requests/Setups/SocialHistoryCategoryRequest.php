<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class SocialHistoryCategoryRequest extends ApiFormRequest
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
        $id = $this->route('socialhistorycategory') ?? null;
        return [
            'name' => 'bail|' . ($id ? 'sometimes' : 'required') . '|' . $this->softUnique('social_history_categories', 'name', $id),
            'status' => 'bail|' . ($id ? 'sometimes' : 'required') . '|in:ACTIVE,INACTIVE'
        ];
    }
}
