<?php

namespace App\Http\Resources\Registrations;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ConsultationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ConsultationResource::collection($this->collection);
    }
}
