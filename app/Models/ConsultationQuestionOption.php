<?php

namespace App\Models;

use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultationQuestionOption extends AuditableModel
{
    use FindByTrait;
    use SoftDeletes;

    protected $guarded = [];

    public function consultation_question()
    {
        return $this->belongsTo(ConsultationQuestion::class);
    }
}
