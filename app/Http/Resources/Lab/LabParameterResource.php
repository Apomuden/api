<?php

namespace App\Http\Resources\Lab;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class LabParameterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $pivot=$this->pivot??null;
        $data= [
            'id'=>$this->id,
            'name'=>$this->name,
            'description'=>$this->description??null,
            'value_type'=>$this->value_type,
            'unit'=>$this->unit
        ];

        if($pivot)
        $data['order']=$pivot->order;

        $data=$data+[
            'status' => $this->status,
            'created_at' => DateHelper::toDisplayDateTime($pivot->created_at??$this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($pivot->updated_at ?? $this->updated_at),
        ];

        return $data;
    }
}
