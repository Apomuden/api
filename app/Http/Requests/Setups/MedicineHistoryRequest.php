<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class MedicineHistoryRequest extends ApiFormRequest
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
        $id = $this->route('medicinehistory') ?? null;
        return [
            'name' => 'bail|' . ($id ? 'sometimes' : 'required') . '|' . $this->softUniqueWith('medicine_histories', 'name,medicine_history_category_id', $id),
            'medicine_history_category_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:medicine_history_categories,id',
            'status' => 'bail|' . ($id ? 'sometimes' : 'required') . '|in:ACTIVE,INACTIVE'
        ];
    }
}
