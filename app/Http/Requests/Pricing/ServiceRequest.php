<?php

namespace App\Http\Requests\Pricing;

use App\Http\Requests\ApiFormRequest;
use App\Models\ServiceCategory;
use App\Models\Service;
use App\Models\ServiceSubcategory;
use App\Repositories\RepositoryEloquent;
use Illuminate\Support\Facades\Log;

class ServiceRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }
    protected $gender = 'MALE,FEMALE';
    protected $patient_status = 'IN-PATIENT,OUT-PATIENT,WALK-IN';
    public function rules()
    {
        $id = $this->route('service') ?? null;

        return [
            'description' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|' . $this->softUnique('services', 'description', $id),
            'hospital_service_id' => 'bail|sometimes|integer|exists:hospital_services,id',
            'service_category_id' => 'bail|sometimes|integer|exists:service_categories,id',
            'service_subcategory_id' => 'bail|sometimes|nullable|integer|exists:service_subcategories,id',
            'age_group_id' => 'bail|sometimes|nullable|integer|exists:age_groups,id',
            'gender' => 'bail|sometimes|nullable|set:' . $this->gender . ',BIGENDER',
            'patient_status' => 'bail|sometimes|set:' . $this->patient_status,
            'prepaid_amount' => 'bail|' . ($id ? 'sometimes' : 'required') . '|numeric',
            'postpaid_amount' => 'bail|' . ($id ? 'sometimes' : 'required') . '|numeric',
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $all = $this->all();
            $service_subcategory_id = $all['service_subcategory_id'] ?? null;
            $service_category_id = $all['service_category_id'] ?? null;
            $age_group_id = $all['age_group_id'] ?? null;
            $gender = $all['gender'] ?? $this->gender;
            $patient_status = $all['patient_status'] ?? $this->patient_status;

            $id = $this->route('service') ?? null;

            if (!$id && !$service_category_id && ! $service_subcategory_id) {
                $validator->errors()->add('service_category', 'Service category id or Service Sub category id is required!');
            } else {
                $repository = new RepositoryEloquent(new Service());
                $where = [
                    'service_category_id' => $service_category_id,
                    'service_subcategory_id' => $service_subcategory_id,
                    'age_group_id' => $age_group_id,
                    'gender' => $gender,
                    'patient_status' => $patient_status,
                    'deleted_at' => null
                ];
                $service = $repository->find($id) ?? $repository->findWhere($where)->first();

                //dd($service);
                if (
                    $service && $service->service_category_id == $service_category_id
                    && $service->service_subcategory_id == $service_subcategory_id
                    && $service->age_group_id == $age_group_id
                    && $service->gender == $gender
                    && $service->patient_status == $patient_status
                    && $service->id != $id
                ) {
                    $validator->errors()->add('service', 'Service already exists!');
                }
            }
        });
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        $service_subcategory_id = $this->input('service_subcategory_id', null);
        $service_category_id = $this->input('service_category_id', null);

        if ($service_subcategory_id) {
              $repository = new RepositoryEloquent(new ServiceSubcategory());
              $service_subcategory = $repository->find($service_subcategory_id);

            if ($service_subcategory) {
                $data['service_category_id'] = $service_subcategory->service_category_id;
                $data['hospital_service_id'] = $service_subcategory->hospital_service_id;
            }
        } elseif ($service_category_id) {
             $repository = new RepositoryEloquent(new ServiceCategory());
             $service_category = $repository->find($service_category_id);

            if ($service_category) {
                $data['hospital_service_id'] = $service_category->hospital_service_id;
            }
        }
        return $data;
    }
}
