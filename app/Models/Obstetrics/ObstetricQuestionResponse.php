<?php

namespace App\Models\Obstetrics;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * @method static updateOrCreate(array $array, array $param)
 */
class ObstetricQuestionResponse extends Model
{
    use ActiveTrait,FindByTrait,SoftDeletes;
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->consultant_id = Auth::guard('api')->user()->id;
            $question = ObstetricQuestion::findOrFail($model->obstetric_question_id);
            $model->step = $question->step;
        });
    }

    public function obstetric_question()
    {
        return $this->belongsTo(ObstetricQuestion::class);
    }

    public function consultant()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
}
