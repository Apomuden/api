<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BillingSponsorResource extends JsonResource
{
    public function toArray($request)
    {
        if(isset($this->id)){
            $sponsorship_type=$this->sponsorship_type;
            $company=$this->company;
            return [
                'id'=>$this->id,
                'name'=>$this->name,
                'sponsorship_type_name'=>$sponsorship_type->name,
                'sponsorship_type_id'=>$sponsorship_type->id,
                'company_name'=>$company->name,
                'company_id'=>$company->id,
                'status'=>$this->status,
            ];
        }
        else
           return NULL;
    }
}
