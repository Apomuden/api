<?php

namespace App\Http\Requests\Pricing;
use App\Http\Requests\ApiFormRequest;
use App\Models\ServiceCategory;
use App\Models\ServicePrice;
use App\Models\ServiceSubcategory;
use App\Repositories\RepositoryEloquent;
use Illuminate\Support\Facades\Log;

class ServicePriceRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   protected $gender='MALE,FEMALE';
   protected $patient_status='IN-PATIENT,OUT-PATIENT,WALK-IN';
   public function rules(){
    $id=$this->route('serviceprice')??null;

        return [
            'description' => 'bail|sometimes|nullable|string',
            'hospital_service_id'=>'bail|sometimes|integer|exists:hospital_services,id',
            'service_category_id'=>'bail|sometimes|integer|exists:service_categories,id',
            'service_subcategory_id'=>'bail|sometimes|nullable|integer|exists:service_subcategories,id',
            'age_group_id'=>'bail|sometimes|nullable|integer|exists:age_groups,id',
            'gender'=>'bail|sometimes|nullable|set:'.$this->gender.',BIGENDER',
            'funding_type_id'=>'bail|sometimes|nullable|integer|exists:funding_types,id',
            'patient_status'=>'bail|sometimes|set:'.$this->patient_status,
            'amount'=>'bail|'.($id?'sometimes':'required').'|numeric',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
   public function withValidator($validator)
   {
        $validator->after(function ($validator) {

            $all=$this->all();
            $service_subcategory_id=$all['service_subcategory_id']??null;
            $service_category_id=$all['service_category_id']??null;
            $funding_type_id=$all['funding_type_id']??null;
            $age_group_id=$all['age_group_id']??null;
            $gender=$all['gender']??$this->gender;
            $patient_status=$all['patient_status']??$this->patient_status;

            $id=$this->route('serviceprice')??null;

            if (!$id && !$service_category_id && ! $service_subcategory_id) {
                $validator->errors()->add('service_category', 'Service category id or Service Sub category id is required!');
            }
            else{
                $repository=new RepositoryEloquent(new ServicePrice);


                $where=[
                    'service_category_id'=>$service_category_id,
                    'service_subcategory_id'=>$service_subcategory_id,
                    'funding_type_id'=>$funding_type_id,
                    'age_group_id'=>$age_group_id,
                    'gender'=>$gender,
                    'patient_status'=>$patient_status
                ];
                $servicePrice=$repository->find($id)??$repository->findWhere($where)->first();


                if($servicePrice && $servicePrice->service_category_id==$service_category_id
                    && $servicePrice->service_subcategory_id==$service_subcategory_id
                    && $servicePrice->funding_type_id==$funding_type_id
                    && $servicePrice->age_group_id==$age_group_id
                    && $servicePrice->gender==$gender
                    && $servicePrice->patient_status==$patient_status
                    && $servicePrice->id!=$id
                )
                $validator->errors()->add('service_price', 'Service price already exists!');
            }
        });
   }

   public function all($keys = null)
  {
    $data = parent::all($keys);
    $service_subcategory_id=$this->input('service_subcategory_id',null);
    $service_category_id=$this->input('service_category_id',null);

    if($service_subcategory_id){
        $repository=new RepositoryEloquent(new ServiceSubcategory);
        $service_subcategory=$repository->find($service_subcategory_id);

        if($service_subcategory){
            $data['service_category_id']=$service_subcategory->service_category_id;
            $data['hospital_service_id']=$service_subcategory->hospital_service_id;
        }

    }
    else if($service_category_id){
        $repository=new RepositoryEloquent(new ServiceCategory);
        $service_category=$repository->find($service_category_id);
        
        if($service_category)
        $data['hospital_service_id']=$service_category->hospital_service_id;
    }
       return $data;
  }
}
