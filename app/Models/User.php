<?php

namespace App\Models;

use App\Http\Helpers\DateHelper;
use App\Http\Helpers\FileResolver;
use App\Http\Helpers\IDGenerator;
use App\Http\Helpers\Security;
use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Cache;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable, ActiveTrait, SortableTrait, FindByTrait, SoftDeletes;

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
        return ucwords(trim($this->firstname . ' ' . $this->middlename) . ' ' . $this->surname);
    }

    public function components()
    {
        return $this->belongsToMany(Component::class);
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'component_user')->distinct();
    }

    public function consultation()
    {
        return $this->hasMany(Consultation::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Str::uuid();
            $model->password = Security::getNewPasswordHash($model->password, $model->id);

            $model->dob = DateHelper::toDBDate($model->dob);

            //get the associated staff type
            $StaffType = StaffType::findOrFail($model->staff_type_id);
            $model->expires = $StaffType->validity_days ? true : false;
            $model->expiry_date = $StaffType->validity_days ? Carbon::now()->addDays($StaffType->validity_days) : null;

            $model->staff_id = IDGenerator::getNewStaffID();

            $model->signature = FileResolver::base64ToFile($model->signature, $model->username, 'users' . DIRECTORY_SEPARATOR . 'signatures') ?? null;
            $model->photo = FileResolver::base64ToFile($model->signature, $model->username, 'users' . DIRECTORY_SEPARATOR . 'photos') ?? null;
        });

        static::updating(function ($model) {
            $model->dob = DateHelper::toDBDate($model->dob);

            $original_password = $model->getOriginal('password');

            if (isset($model->password) && $original_password != $model->password)
                $model->password = Security::getNewPasswordHash($model->password, $model->id);


            $model->signature = FileResolver::base64ToFile($model->signature, $model->username, 'users' . DIRECTORY_SEPARATOR . 'signatures') ?? null;
            $model->photo = FileResolver::base64ToFile($model->photo, $model->username, 'users' . DIRECTORY_SEPARATOR . 'photos') ?? null;
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

    public function staff_specialty()
    {
        return $this->belongsTo(StaffSpecialty::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'origin_country_id');
    }
    public function region()
    {
        return $this->belongsTo(Region::class, 'origin_region_id');
    }

    public function hometown()
    {
        return $this->belongsTo(Town::class, 'hometown_id');
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

    public function recoveries()
    {
        return $this->hasMany(PasswordReset::class);
    }
    static function getCategorySummary()
    {
        return self::select('staff_category_id', DB::raw('count(*) as total'))->groupBy('staff_category_id')->whereHas('staff_category')->get();
    }

    public function detachModules($modules)
    {
        foreach ($modules as $module) {
            ComponentUser::where('user_id', $this->id)
                ->where('module_id', $module)
                ->delete();
        }
        $this->deleteCache();
    }
    public function syncModules($modules, $detach = false)
    {
        $payload = [];
        foreach ($modules as $module) {
            $module = (object) $module;
            $components = Module::with('components')->where('id', $module->id)->first()->components;
            foreach ($components as $component) {

                if (isset($module->all)) {
                    $payload[$component->id] = [
                        'all' => $module->all ?? false,
                        'add' => $module->all ?? false,
                        'view' => $module->all ?? false,
                        'edit' => $module->all ?? false,
                        'update' => $module->all ?? false,
                        'delete' => $module->all ?? false,
                        'print' => $module->all ?? false,
                    ];
                }

                $payload[$component->id]['module_id'] = $module->id;
                if (isset($module->add))
                    $payload[$component->id]['add'] = $module->all ? $module->all : ($module->add ?? false);
                if (isset($module->view))
                    $payload[$component->id]['view'] = $module->all ? $module->all : ($module->view ?? false);

                if (isset($module->edit))
                    $payload[$component->id]['edit'] = $module->all ? $module->all : ($module->edit ?? false);

                if (isset($module->update))
                    $payload[$component->id]['update'] = $module->all ? $module->all : ($module->update ?? false);

                if (isset($module->delete))
                    $payload[$component->id]['delete'] = $module->all ? $module->all : ($module->delete ?? false);

                if (isset($module->print))
                    $payload[$component->id]['print'] = $module->all ? $module->all : ($module->print ?? false);
            }
        }
        $this->components()->sync($payload, $detach);
        $this->deleteCache();
    }
    public function syncComponents($components, $detach = false)
    {
        $payload = [];
        $components = $components;
        foreach ($components as $component) {
            $component = (object) $component;
            $dbcomponent = ComponentModule::where('component_id', $component->id)->first();
            if (!$dbcomponent)
                continue;

            if (isset($component->all)) {
                $payload[$component->id] = [
                    'all' => $component->all ?? false,
                    'add' => $component->all ?? false,
                    'view' => $component->all ?? false,
                    'edit' => $component->all ?? false,
                    'update' => $component->all ?? false,
                    'delete' => $component->all ?? false,
                    'print' => $component->all ?? false,
                ];
            }

            $payload[$component->id]['module_id'] = $dbcomponent->module_id;

            if (isset($component->add))
                $payload[$component->id]['add'] = $component->all ? $component->all : ($component->add ?? false);
            if (isset($component->view))
                $payload[$component->id]['view'] = $component->all ? $component->all : ($component->view ?? false);

            if (isset($component->edit))
                $payload[$component->id]['edit'] = $component->all ? $component->all : ($component->edit ?? false);

            if (isset($component->update))
                $payload[$component->id]['update'] = $component->all ? $component->all : ($component->update ?? false);

            if (isset($component->delete))
                $payload[$component->id]['delete'] = $component->all ? $component->all : ($component->delete ?? false);

            if (isset($component->print))
                $payload[$component->id]['print'] = $component->all ? $component->all : ($component->print ?? false);
        }
        $this->components()->sync($payload, $detach);
        $this->deleteCache();
    }

    public function detachComponents($components)
    {
        foreach ($components as  $component) {
            ComponentUser::where('component_id', $component)
                ->where('user_id', $this->id)
                ->delete();
        }

        $this->deleteCache();
    }

    private function deleteCache()
    {
        $key = 'components->user->' . $this->id;
        Cache::forget($key);
    }
}
