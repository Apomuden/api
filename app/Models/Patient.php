<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Constraint\Count;

class Patient extends Model
{
    use ActiveTrait,FindByTrait;
  protected $guarded = [];
  public function folders()
  {
      return $this->belongsToMany(Folder::class);
  }

  public function country()
  {
      return $this->belongsTo(Country::class,'origin_country_id');
  }

  public function region()
  {
      return $this->belongsTo(Region::class,'origin_region_id');
  }

  public function district()
  {
      return $this->belongsTo(District::class,'origin_district_id');
  }
}
