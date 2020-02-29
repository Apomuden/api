<?php

namespace App\Http\Resources\Registrations;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PatientVitalCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function toArray($request)
    {
        return PatientVitalResource::collection($this->collection);
    }
}
