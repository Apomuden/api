<?php

namespace App\Http\Resources\Obstetrics;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ObstetricQuestionOptionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ObstetricQuestionOptionResource::collection($this->collection);

    }
}
