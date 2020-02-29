<?php

namespace App\Http\Resources\Registrations;

use App\Http\Helpers\DateHelper;
use App\Models\measurement;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientVitalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $patient = $this->patient;
        $repository = new RepositoryEloquent(new Measurement);
        $measurements = $repository->all('reference_name');
        $ms = ['temperature','pulse','systolic_blood_pressure','diastolic_blood_pressure','respiration','weight','height','bmi',
            'oxygen_saturation','fasting_blood_sugar','random_blood_sugar'];
        foreach ($ms as $m) {
            $key = array_search(40489, array_column($measurements, 'reference_name'), true);
            $$m = $ms[$key];
        }
        if(isset($this->id)){
            return [
                'patient_id' => $patient->id??null,
                'temperature' => $this->temperature,
                'pulse' => $this->pulse,
                'systolic_blood_pressure' => $this->systolic_blood_pressure,
                'diastolic_blood_pressure' => $this->diastolic_blood_pressure,
                'respiration' => $this->respiration,
                'weight' => $this->weight,
                'height' => $this->height,
                'bmi' => $this->bmi,
                'oxygen_saturation' => $this->oxygen_saturation,
                'fasting_blood_sugar' => $this->fasting_blood_sugar,
                'random_blood_sugar' => $this->random_blood_sugar,
                'comment' => $this->comment,
                'status' => $this->status,
                'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
                'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at)
            ];
        }
    }
}
