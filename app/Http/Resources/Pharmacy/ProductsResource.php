<?php

namespace App\Http\Resources\Pharmacy;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $product_type = $this->product_type??null;
        $product_category = $this->product_category??null;
        $product_form = $this->product_form??null;
        $product_form_unit = $this->product_form_unit??null;
        $medicine_route = $this->medicine_route??null;
        $age_group = $this->age_group??null;
        return [
            'id' => $this->id,
            'brand_name' => $this->brand_name,
            'generic_name' => $this->generic_name,
            'product_type_name'=> $product_type->name??null,
            'product_type_id'=> $product_type->id??null,
            'product_form_name'=> $product_form->name??null,
            'product_form_id'=> $product_form->id??null,
            'product_form_unit_name'=> $product_form_unit->name??null,
            'product_form_unit_id'=> $product_form_unit->id??null,
            'medicine_route_name'=> $medicine_route->name??null,
            'medicine_route_id'=> $medicine_route->id??null,
            'product_category_name'=> $product_category->name??null,
            'product_category_id'=> $product_category->id??null,
            'maximum_form_issue_unit' => $this->maximum_form_issue_unit,
            'default_minimum_dosage' => $this->default_minimum_dosage,
            'package_maximum_issue' => $this->package_maximum_issue,
            'strength_equivalent' => $this->strength_equivalent,
            'gender'=> $this->gender,
            'age_group_name' => $age_group->name??null,
            'age_group_id' => $age_group->id??null,
            'nhis_cover' => $this->nhis_cover,
            'expires' => $this->nhis_code,
            'status' => $this->status,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
        ];
    }
}
