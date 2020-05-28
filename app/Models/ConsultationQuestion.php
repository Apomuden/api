<?php

namespace App\Models;

use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultationQuestion extends Model
{
    use FindByTrait, SoftDeletes;
    protected $guarded = [];

    public function consultation_question_options()
    {
        return $this->hasMany(ConsultationQuestionOption::class);
    }
}
