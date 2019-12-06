<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
  public function folders()
  {
      return $this->belongsToMany(Folder::class);
  }
}
