<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AccreditationResource extends JsonResource
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
            'reg_body'=>$this->reg_body,
            'reg_no'=>$this->reg_no,
            'tin'=>$this->tin,
            'reg_date'=>$this->formatedregdate??null,
            'expiry_date'=>$this->formatedexpirydate??null,
            'status'=>$this->status
        ];
    }
}
