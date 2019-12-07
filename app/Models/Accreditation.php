<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Accreditation extends Model
{
    protected $guarded = [];

    protected $dateFormat="Y-m-d";
    protected $casts = [
        'reg_date' => 'date',
        'expiry_date'=>'date',
        'status'=>'string'
    ];

    function getFormatedRegDateAttribute(){

      return  (new Carbon($this->reg_date))->isoFormat('D-M-Y');
    }
    function getFormatedExpiryDateAttribute(){
      return (new Carbon($this->expiry_date))->isoFormat('D-M-Y');
    }
}
