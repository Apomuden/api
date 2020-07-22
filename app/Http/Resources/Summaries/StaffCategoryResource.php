<?php

namespace App\Http\Resources\Summaries;

use Illuminate\Http\Resources\Json\JsonResource;

class StaffCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
            $staff_category = $this->staff_category ?? null;

           // if($staff_category)
            return [
                'id' => $staff_category->id ?? null,
                'staff_category_name' => $staff_category->name ?? null,
                'total' => $this->total
            ];
           // else return null;
    }
}
