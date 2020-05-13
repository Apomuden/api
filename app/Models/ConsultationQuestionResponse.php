<?php

namespace App\Models;

use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static updateOrCreate(array $array, array $except)
 */
class ConsultationQuestionResponse extends Model
{
    use FindByTrait, SoftDeletes;
    protected $guarded = [];

    public function consultation_question()
    {
        return $this->belongsTo(ConsultationQuestion::class);
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
