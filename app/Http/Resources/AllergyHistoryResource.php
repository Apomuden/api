<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AllergyHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $allergy_history_category = $this->allergy_history_category;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'allergy_history_category_id' => $allergy_history_category->id ?? null,
            'allergy_history_category_name' => $allergy_history_category->name ?? null,
            'status' => $this->status,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at
        ];
    }
}
