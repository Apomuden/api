<?php

namespace App\Http\Resources\Obstetrics;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ObstetricQuestionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ObstetricQuestionResource::collection($this->collection);
    }
}
