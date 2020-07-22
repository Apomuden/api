<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PhysicalExaminationTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $category = $this->category;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category_id' => $category->id ?? null,
            'category_name' => $category->name ?? null,
            'status' => $this->status,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at
        ];
    }
}
