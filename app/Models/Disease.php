<?php
namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disease extends AuditableModel
{
    use ActiveTrait, FindByTrait, SoftDeletes;

    protected $guarded = [];

    public function moh_ghs_grouping()
    {
        return $this->belongsTo(MohGhsGrouping::class);
    }

    public function icd10_grouping()
    {
        return $this->belongsTo(Icd10Grouping::class);
    }

    public function icd10_category()
    {
        return $this->belongsTo(Icd10Category::class);
    }

    public function illness_type()
    {
        return $this->belongsTo(IllnessType::class);
    }

    public function age_group()
    {
        return $this->belongsTo(AgeGroup::class, 'age_group_id');
    }
}
