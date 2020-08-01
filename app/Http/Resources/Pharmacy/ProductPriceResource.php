<?php

namespace App\Http\Resources\Pharmacy;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductPriceResource extends JsonResource
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
            'product_id'=>$this->product_id,
            'product_name'=>$this->product->brand_name??null,
            'product_type_id'=>$this->product_type_id,
            'product_type_name'=>$this->product_type->name??null,
            'product_category_id'=>$this->product_category_id,
            'product_category_name'=>$this->product_category->name??null,
            'product_form_unit_id'=>$this->product_form_unit_id,
            'product_form_unit_name'=>$this->product_form_unit->name??null,
            'current_unit_cost'=>floatval($this->current_unit_cost),
            'previous_unit_cost'=> floatval($this->previous_unit_cost),
            'variance_unit_cost'=> floatval($this->variance_unit_cost),
            'prepaid_amount'=> floatval($this->prepaid_amount),
            'postpaid_amount'=> floatval($this->postpaid_amount),
            'nhis_amount'=> floatval($this->nhis_amount),
            
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
        ];
    }
}
