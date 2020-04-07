<?php

namespace App\Http\Resources\Registrations;

use App\Http\Helpers\DateHelper;
use App\Models\Measurement;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

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
        $measurements = Measurement::all()->toArray();

        $ms = ['temperature','pulse','systolic_blood_pressure','diastolic_blood_pressure','respiration','weight','height','bmi',
            'oxygen_saturation','fasting_blood_sugar','random_blood_sugar'];
        $mid = array_column($measurements, 'id');
        array_multisort($mid, SORT_ASC, $measurements);

        foreach ($ms as $m) {
            $valIndex = array_search($m, array_column($measurements, 'reference_name'), true);
            $$m = json_decode(json_encode($measurements[$valIndex]));
        }
        if(isset($this->id)){
            return [
                'id' => $this->id,
                'patient_id' => $patient->id??null,
                'temperature' => [
                    'value'=>$this->temperature?(double) $this->temperature:null,
                    'unit'=>$temperature->unit??null,
                    'min_value'=>$temperature->min_value?(double) $temperature->min_value:null,
                    'max_value'=>$temperature->max_value?(double) $temperature->max_value:null,
                ],
                'pulse' => [
                    'value'=>$this->pulse?(double) $this->pulse:null,
                    'unit'=>$pulse->unit??null,
                    'min_value'=>$pulse->min_value?(double) $pulse->min_value:null,
                    'max_value'=>$pulse->max_value?(double) $pulse->max_value:null,
                ],
                'systolic_blood_pressure' => [
                    'value'=>$this->systolic_blood_pressure?(double) $this->systolic_blood_pressure:null,
                    'unit'=>$systolic_blood_pressure->unit??null,
                    'min_value'=>$systolic_blood_pressure->min_value?(double) $systolic_blood_pressure->min_value:null,
                    'max_value'=>$systolic_blood_pressure->max_value?(double) $systolic_blood_pressure->max_value:null,
                ],
                'diastolic_blood_pressure' => [
                    'value'=>$this->diastolic_blood_pressure?(double) $this->diastolic_blood_pressure:null,
                    'unit'=>$diastolic_blood_pressure->unit??null,
                    'min_value'=>$diastolic_blood_pressure->min_value?(double) $diastolic_blood_pressure->min_value:null,
                    'max_value'=>$diastolic_blood_pressure->max_value?(double) $diastolic_blood_pressure->max_value:null,
                ],
                'respiration' => [
                    'value'=>$this->respiration?(double) $this->respiration:null,
                    'unit'=>$respiration->unit??null,
                    'min_value'=>$respiration->min_value?(double) $respiration->min_value:null,
                    'max_value'=>$respiration->max_value?(double) $respiration->max_value:null,
                ],
                'weight' => [
                    'value'=>$this->weight?(double) $this->weight:null,
                    'unit'=>$weight->unit??null,
                    'min_value'=>$weight->min_value?(double) $weight->min_value:null,
                    'max_value'=>$weight->max_value?(double) $weight->max_value:null,
                ],
                'height' => [
                    'value'=>$this->height ? (double) $this->height:null,
                    'unit'=>$height->unit??null,
                    'min_value'=>$height->min_value ?(double) $height->min_value:null,
                    'max_value'=>$height->max_value?(double) $height->max_value:null,
                ],
                'bmi' => [
                    'value'=>$this->bmi?(double) $this->bmi:null,
                    'unit'=>$bmi->unit??null,
                    'min_value'=>$bmi->min_value?(double) $bmi->min_value:null,
                    'max_value'=>$bmi->max_value?(double) $bmi->max_value:null,
                ],
                'oxygen_saturation' => [
                    'value'=>$this->oxygen_saturation?(double) $this->oxygen_saturation:null,
                    'unit'=>$oxygen_saturation->unit??null,
                    'min_value'=>$oxygen_saturation->min_value?(double) $oxygen_saturation->min_value:null,
                    'max_value'=>$oxygen_saturation->max_value?(double) $oxygen_saturation->max_value:null,
                ],
                'fasting_blood_sugar' => [
                    'value'=>$this->fasting_blood_sugar?(double) $this->fasting_blood_sugar:null,
                    'unit'=>$fasting_blood_sugar->unit??null,
                    'min_value'=>$fasting_blood_sugar->min_value?(double) $fasting_blood_sugar->min_value:null,
                    'max_value'=>$fasting_blood_sugar->max_value?(double) $fasting_blood_sugar->max_value:null,
                ],
                'random_blood_sugar' => [
                    'value'=>$this->random_blood_sugar?(double) $this->random_blood_sugar:null,
                    'unit'=>$random_blood_sugar->unit??null,
                    'min_value'=>$random_blood_sugar->min_value?(double) $random_blood_sugar->min_value:null,
                    'max_value'=>$random_blood_sugar->max_value?(double) $random_blood_sugar->max_value:null,
                ],
                'comment' => $this->comment,
                'status' => $this->status,
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
            ];
        }
    }
}
