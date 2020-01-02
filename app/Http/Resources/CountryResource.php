<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
            'name'=>$this->country_name,
            'code'=>$this->country_code,
            'flag'=>\route('file.url',['flags',strtolower($this->country_code).'.png']),
            'call_code'=>$this->call_code,
            'currency'=>$this->currency,
            'alt_currency'=>$this->alternate_currency,
            'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
            'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at)
        ];
    }
}
