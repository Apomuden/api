<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
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
            'reg_date'=>DateHelper::toDisplayDate($this->reg_date),
            'expiry_date'=>DateHelper::toDisplayDate($this->expiry_date),
            'status'=>$this->status,
            'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
            'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at),
        ];
    }
}
