<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ClinicResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (isset($this->id)) {
            $service_category = $this->service_category;

            return [
                'id' => $this->id,
                'name' => $this->name,
                'service_category_name' => $service_category->name ?? null,
                'service_category_id' => $service_category->id ?? $this->service_category_id ?? null,
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
            ];
        } else {
            return NULL;
        }
    }
}
