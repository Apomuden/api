<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class DiseaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

            return [
                'id'=>$this->id,
                'name'=>$this->name,
                'disease_code'=>$this->disease_code,
                'moh_ghs_grouping_id'=>$this->moh_ghs_grouping->id??null,
                'moh_ghs_grouping_name'=>$this->moh_ghs_grouping->name??null,
                'icd10_code'=>$this->icd10_code??null,
                'icd10_grouping_id'=>$this->icd10_grouping->id??null,
                'icd10_grouping_name'=>$this->icd10_grouping->name??null,
                'icd10_grouping_code' => $this->icd10_grouping_code,

                'icd10_category_id'=>$this->icd10_category->id??null,
                'icd10_category_name'=>$this->icd10_category->name??null,

                'adult_gdrg'=>$this->adult_gdrg??null,
                'adult_tariff'=>$this->adult_tariff??null,

                'child_gdrg'=>$this->child_gdrg??null,
                'child_tariff'=>$this->child_tariff??null,

                'illness_type_id'=>$this->illness_type->id??null,
                'illness_type_name'=>$this->illness_type->name??null,

                'age_group_id'=>$this->age_group_id,
                'age_group_name'=>$this->age_group->name??null,

                'gender'=>$this->gender??null,

                'status'=>$this->status,
                
                'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
                'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at)
            ];

    }
}
