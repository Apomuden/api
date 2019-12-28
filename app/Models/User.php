<?php

namespace App\Models;

use App\Http\Helpers\FileResolver;
use App\Http\Helpers\IDGenerator;
use App\Http\Helpers\Security;
use App\Http\Traits\ActiveTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable,ActiveTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public $incrementing = false;
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
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

            $model->signature=FileResolver::base64ToFile($model->signature,$model->username,'users'.DIRECTORY_SEPARATOR.'signatures')??null;
            $model->photo=FileResolver::base64ToFile($model->signature,$model->username,'users'.DIRECTORY_SEPARATOR.'photos')??null;
        });

        static::updating(function($model){
            $model->signature=FileResolver::base64ToFile($model->signature,$model->username,'users'.DIRECTORY_SEPARATOR.'signatures')??null;
            $model->photo=FileResolver::base64ToFile($model->photo,$model->username,'users'.DIRECTORY_SEPARATOR.'photos')??null;

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


    public function title()
    {
        return $this->belongsTo(Title::class);
    }
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
        return $this->belongsTo(Department::class);
    }

    public function id_type()
    {
        return $this->belongsTo(IdType::class);
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }
    public function educational_level()
    {
        return $this->belongsTo(EducationalLevel::class);
    }

    public function staff_type()
    {
        return $this->belongsTo(StaffType::class);
    }

    public function staff_category()
    {
        return $this->belongsTo(StaffCategory::class);
    }

    public function specialty()
    {
        return $this->belongsTo(StaffSpecialty::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class,'origin_country_id');
    }
    public function region()
    {
        return $this->belongsTo(Region::class,'origin_region_id');
    }

    public function hometown()
    {
        return $this->belongsTo(Town::class,'hometown_id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function bank_branch()
    {
        return $this->belongsTo(BankBranch::class);
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    public function emerg_relation()
    {
        return $this->belongsTo(Relationship::class);
    }

    public function documents()
    {
        return $this->hasMany(UserDocument::class);
    }

    public function nextofkins()
    {
        return $this->hasMany(StaffNextOfKin::class);
    }
    public function attachPermissions($permissions){
            try{
                $this->permissions()->attach($permissions);
            }
            catch(Exception $e){}
    }
    public function detachPermissions($permissions){
            try{
                $this->permissions()->detach($permissions);
            }
            catch(Exception $e){}
    }

    public function attachModules($module_ids){
        $modules=Module::with(['components'=>function($q){$q->with('permissions');}])->whereIn('id',$module_ids)->get();
        foreach($modules as $module){
           $components=$module->components;
           foreach($components as $component){
               $permissions=$component->permissions;
               $this->attachPermissions($permissions);
           }
        }
     }

     public function detachModules($module_ids){
         $modules=Module::with(['components'=>function($q){$q->with('permissions');}])->whereIn('id',$module_ids)->get();
         foreach($modules as $module){
            $components=$module->components;
            foreach($components as $component){
                $permissions=$component->permissions;
               $this->detachPermissions($permissions);
            }
         }
      }
}
