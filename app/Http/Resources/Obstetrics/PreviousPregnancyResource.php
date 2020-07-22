<?php

namespace App\Http\Resources\Obstetrics;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed patient_id
 * @property mixed patient_status
 * @property mixed consultation_id
 * @property mixed patient_age
 * @property mixed gestational_week_id
 * @property mixed problem_during_pregnancy
 * @property mixed delivery_outcome
 * @property mixed delivery_outcome_id
 * @property mixed delivery_mode_id
 * @property mixed birth_place_id
 * @property mixed labour_postpartum_complication
 * @property mixed birth_weight
 * @property mixed gender
 * @property mixed date
 * @property mixed child_health
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed user_id
 * @property mixed gestational_week
 * @property mixed delivery_mode
 * @property mixed birth_place
 */
class PreviousPregnancyResource extends JsonResource
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
                'consultation_id' => $this->consultation_id,
                'patient_age' => $this->patient_age,
                'patient_status' => $this->patient_status,
                'date' => DateHelper::toDisplayDateTime($this->date),
                'problem_during_pregnancy' => $this->problem_during_pregnancy,
                'birth_place' => $this->birth_place,
//                'birth_place_id' => $this->birth_place_id,
                'gestational_week' => $this->gestational_week,
//                'gestational_week_id' => $this->gestational_week_id,
                'delivery_mode' => $this->delivery_mode,
//                'delivery_mode_id' => $this->delivery_mode_id,
                'delivery_outcome' => $this->delivery_outcome,
//                'delivery_outcome_id' => $this->delivery_outcome_id,
                'labour_postpartum_complication' => $this->labour_postpartum_complication,
                'gender' => $this->gender,
                'birth_weight' => $this->birth_weight,
                'child_health' => $this->child_health,
                'user_id' => $this->user_id,
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),

            ];
        }

        return null;
    }
}
