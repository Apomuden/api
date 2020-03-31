<?php

namespace App\Http\Resources;

use App\Models\ServiceSubcategory;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ServiceSubCategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return  ServiceSubcategoryResource::collection($this->collection);

    }
}
