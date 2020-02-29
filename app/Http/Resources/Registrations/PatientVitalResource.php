<?php

namespace App\Http\Resources\Registrations;

use App\Http\Helpers\DateHelper;
use App\Models\measurement;
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
        //$repository = new RepositoryEloquent(new Measurement);
        //$measurements = (array) $repository->all('reference_name');
        $measurements=DB::table('measurements')->select('unit','min_value','max_value','reference_name')->get();
        $measurements=array_map(function($item){
            return (array) $item;
        }, (array)$measurements);
        $ms = ['temperature','pulse','systolic_blood_pressure','diastolic_blood_pressure','respiration','weight','height','bmi',
            'oxygen_saturation','fasting_blood_sugar','random_blood_sugar'];
        foreach ($ms as $m) {
            $key = array_search($m, array_column($measurements, 'reference_name'), true);
            $$m = $ms[$key];
        }
        if(isset($this->id)){
            return [
                'patient_id' => $patient->id??null,
                'temperature' => [
                    'value'=>$this->temperature,
                    'unit'=>$temperature->unit??null,
                    'min_value'=>$temperature->min_value??null,
                    'max_value'=>$temperature->max_value??null,
                ],
                'pulse' => [
                    'value'=>$this->pulse,
                    'unit'=>$temperature->unit??null,
                    'min_value'=>$temperature->min_value??null,
                    'max_value'=>$temperature->max_value??null,
                ],
                'systolic_blood_pressure' => [
                    'value'=>$this->systolic_blood_pressure,
                    'unit'=>$temperature->unit??null,
                    'min_value'=>$temperature->min_value??null,
                    'max_value'=>$temperature->max_value??null,
                ],
                'diastolic_blood_pressure' => [
                    'value'=>$this->diastolic_blood_pressure,
                    'unit'=>$temperature->unit??null,
                    'min_value'=>$temperature->min_value??null,
                    'max_value'=>$temperature->max_value??null,
                ],
                'respiration' => [
                    'value'=>$this->respiration,
                    'unit'=>$temperature->unit??null,
                    'min_value'=>$temperature->min_value??null,
                    'max_value'=>$temperature->max_value??null,
                ],
                'weight' => [
                    'value'=>$this->weight,
                    'unit'=>$temperature->unit??null,
                    'min_value'=>$temperature->min_value??null,
                    'max_value'=>$temperature->max_value??null,
                ],
                'height' => [
                    'value'=>$this->height,
                    'unit'=>$temperature->unit??null,
                    'min_value'=>$temperature->min_value??null,
                    'max_value'=>$temperature->max_value??null,
                ],
                'bmi' => [
                    'value'=>$this->bmi,
                    'unit'=>$bmi->unit??null,
                    'min_value'=>$bmi->min_value??null,
                    'max_value'=>$bmi->max_value??null,
                ],
                'oxygen_saturation' => [
                    'value'=>$this->oxygen_saturation,
                    'unit'=>$oxygen_saturation->unit??null,
                    'min_value'=>$oxygen_saturation->min_value??null,
                    'max_value'=>$oxygen_saturation->max_value??null,
                ],
                'fasting_blood_sugar' => [
                    'value'=>$this->fasting_blood_sugar,
                    'unit'=>$fasting_blood_sugar->unit??null,
                    'min_value'=>$fasting_blood_sugar->min_value??null,
                    'max_value'=>$fasting_blood_sugar->max_value??null,
                ],
                'random_blood_sugar' => [
                    'value'=>$this->random_blood_sugar,
                    'unit'=>$random_blood_sugar->unit??null,
                    'min_value'=>$random_blood_sugar->min_value??null,
                    'max_value'=>$random_blood_sugar->max_value??null,
                ],
                'comment' => $this->comment,
                'status' => $this->status,
                'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
                'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at)
            ];
        }
    }
}
