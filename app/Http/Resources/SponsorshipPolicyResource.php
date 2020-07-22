<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SponsorshipPolicyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $billing_sponsor = $this->billing_sponsor ?? null;

        if (isset($this->id)) {
            return [
            'id' => $this->id,
            'name' => $this->name,
            'billing_sponsor_name' => $billing_sponsor->name ?? null,
            'billing_sponsor_id' => $billing_sponsor->id ?? null,
            'status' => $this->status,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
            ];
        } else {
            return null;
        }
    }
}
