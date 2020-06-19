<?php

namespace App\Http\Resources\Obstetrics;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int deceased
 * @property int abortions
 * @property int consultation_id
 * @property int full_term
 * @property int gravida
 * @property int patient_status
 * @property int multiple_birth
 * @property int induced
 * @property int patient_age
 * @property int living
 * @property int patient_id
 * @property int premature
 * @property int spontaneous
 * @property int user_id
 * @property mixed created_at
 * @property mixed updated_at
 */
class ObstetricHistoryResource extends JsonResource
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
                'id' => $this->id,
                'patient_id' => $this->patient_id,
                'user_id' => $this->user_id,

                'abortions' => $this->abortions,
                'consultation_id' => $this->consultation_id,
                'deceased' => $this->deceased,
                'full_term' => $this->full_term,
                'gravida' => $this->gravida,
                'induced' => $this->induced,
                'living' => $this->living,
                'multiple_birth' => $this->multiple_birth,
                'patient_age' => $this->patient_age,
                'patient_status' => $this->patient_status,
                'premature' => $this->premature,
                'spontaneous' => $this->spontaneous,

                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
            ];
        }

        return NULL;
    }
}
