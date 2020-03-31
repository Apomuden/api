<?php

namespace App\Http\Resources\Registrations;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SponsorshipRenewalCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function toArray($request)
    {
        return SponsorshipRenewalResource::collection($this->collection);
    }
}
