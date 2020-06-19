<?php

namespace App\Http\Resources\Obstetrics;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed name
 * @property mixed created_at
 * @property mixed updated_at
 */
class ObsBirthPlaceResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        if (isset($this->id)) {
            return [
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'id' => $this->id,
                'name' => $this->name,
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
            ];
        }

        return NULL;
    }
}
