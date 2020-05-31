<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed status
 * @property mixed created_at
 * @property mixed updated_at
 */
class ServiceConsultationComponentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $pivot = $this->pivot ?? null;
        $data = [
            'id' => $this->id,
            'name' => $this->name
        ];

        if ($pivot)
            $data['order'] = $pivot->order;

        $data = $data + [
                'status' => $this->status,
                'created_at' => DateHelper::toDisplayDateTime($pivot->created_at ?? $this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($pivot->updated_at ?? $this->updated_at),
            ];

        return $data;
    }
}
