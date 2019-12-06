<?php

namespace App\Models;

use App\Http\Helpers\IDGenerator;
use App\Http\Helpers\Security;
use App\Http\Traits\ActiveTrait;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class User extends Authenticatable
{
    use Notifiable,ActiveTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public $incrementing = false;

    public function getFullNameAttribute()
    {
      return ucwords(trim($this->firstname.' '.$this->middlename).' '.$this->surname);
    }


    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $model->id=Str::uuid();
            $model->password=Security::getNewPasswordHash($model->password,$model->id);

            //get the associated staff type
            $StaffType=StaffType::findOrFail($model->staff_type_id);
            $model->expires =$StaffType->validity_days?true:false;
            $model->expiry_date =$StaffType->validity_days?Carbon::now()->addDays($StaffType->validity_days):null;

            $model->staff_id=IDGenerator::getNewStaffID();
        });
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'dob' => 'date',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function department()
    {
        return $this->hasOne(Department::class);
    }
}
