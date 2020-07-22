<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class Icd10GroupingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
            $icd10category = $this->icd10category;
            return [
                'id' => $this->id,
                'name' => $this->name,
                'icd10_grouping_code' => $this->icd10_grouping_code,
                'icd10_category_id' => $this->icd10_category_id,
                'icd10_category_name' => $icd10category->name ?? null,
                'status' => $this->status,
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
            ];
    }
}
