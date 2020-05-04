<?php

namespace App\Http\Resources\Pharmacy;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $store = $this->store??null;
        $user = $this->user??null;
        return [
            'id'=>$this->id,
            'store_name'=>$store->name??null,
            'store_id'=>$store->id??null,
            'created_at'=>DateHelper::toDisplayDateTime($this->created_at)??null,
            'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at)??null
        ];
    }
}
