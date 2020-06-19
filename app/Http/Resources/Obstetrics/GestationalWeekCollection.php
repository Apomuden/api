<?php

namespace App\Http\Resources\Obstetrics;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GestationalWeekCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return AnonymousResourceCollection
     */
    public function toArray($request)
    {
        return GestationalWeekResource::collection($this->collection);
    }
}
