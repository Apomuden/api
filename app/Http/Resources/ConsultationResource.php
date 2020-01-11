<?php

namespace App\Http\Resources;

use App\Models\Title;
use App\Models\Patient;
use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultationResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (isset($this->id)) {
            $clinic = $this->clinic;
            $user = $this->user;
            $patient = $this->patient;

            return [
                'id' => $this->id,
                'consultation_given' => $this->consultation_given,
                'clinic_name' => $clinic->name ?? null,
                'clinic_id' => $clinic->id ?? $this->clinic_id ?? null,
                'consultant' => [
                    'id' => $user->id ?? $this->user_id ?? null,
                    'title' => Title::where('id', $user->title_id)->first()->name ?? null,
                    'middlename' => $this->user_id ? $user->middlename : NULL,
                    'firstname' => $this->user_id ? $user->firstname : NULL,
                    'surname' => $this->user_id ? $user->surname : NULL
                ],
                'patient' => [
                    'id' => $patient->id ?? $this->patient_id ?? null,
                    'title' => $this->patient_id ? (Title::where('id', $patient->title_id)->first()->name ?? null) : null,
                    'middlename' => $this->patient_id ? $patient->middlename : NULL,
                    'firstname' => $this->patient_id ? $patient->firstname : NULL,
                    'surname' => $this->patient_id ? $patient->surname : NULL
                ],
                'user_id' => $user->id ?? $this->user_id ?? null,
                'patient_id' => $patient->id ?? $this->patient_id ?? null,
                'scheduled_for' => DateHelper::toDisplayDateTime($this->scheduled_for),
                'started_at' => DateHelper::toDisplayDateTime($this->started_at),
                'ended_at' => DateHelper::toDisplayDateTime($this->ended_at),
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
            ];
        }

        return NULL;
    }
}
