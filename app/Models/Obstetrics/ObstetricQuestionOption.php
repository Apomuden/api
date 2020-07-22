<?php

namespace App\Models\Obstetrics;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Models\AuditableModel;
use App\Models\ConsultationQuestion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ObstetricQuestionOption extends AuditableModel
{
    use ActiveTrait;
    use FindByTrait;
    use SoftDeletes;

    protected $guarded = [];

    public function obstetric_question()
    {
        return $this->belongsTo(ConsultationQuestion::class);
    }
}
