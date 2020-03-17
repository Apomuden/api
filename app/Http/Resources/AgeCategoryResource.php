<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class AgeCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(isset($this->id)) {
            $age_classification = $this->age_classification ?? null;
            $age_group = $this->age_group ?? null;
            return [
                'id'=>$this->id,
                'description' => $this->description,
                'age_classification_name' => $age_classification->name ?? null,
                'age_classification_id' => $age_classification->id ?? null,
                'age_group_name' => $age_group->name ?? null,
                'age_group_id' => $age_group->id ?? null,
                'min_unit' => $this->min_unit,
                'max_unit' => $this->max_unit,
                'min_comparator' => $this->min_comparator,
                'max_comparator' => $this->max_comparator,
                'max_age' => $this->max_age,
                'status' => $this->status,
                'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
                'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at)
            ];
        }

        return null;
    }
}
