<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ClinicAttributeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return object
     */
    public function toArray($request) : object
    {
        return  ClinicAttributeResource::collection($this->collection);
    }
}
