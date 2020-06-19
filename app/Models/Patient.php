<?php

namespace App\Models;

use App\Http\Helpers\DateHelper;
use App\Http\Helpers\FileResolver;
use App\Http\Helpers\IDGenerator;
use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use App\Repositories\RepositoryEloquent;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static findOrFail($patient_id)
 * @method static find($patient_id)
 */
class Patient extends Model
{
    use ActiveTrait, FindByTrait, SortableTrait, SoftDeletes;
    protected $guarded = [];
    private $age_unit;
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->dob = DateHelper::toDBDate($model->dob);

            $model->id_expiry_date = DateHelper::toDBDate($model->id_expiry_date);

            $model->patient_id = IDGenerator::getNewPatientID(($model->reg_status ?? null));

            $model->photo = FileResolver::base64ToFile($model->signature, $model->patient_id, 'patients' . DIRECTORY_SEPARATOR . 'photos') ?? null;

            //Passing the Billing References
            $repository = new RepositoryEloquent(new FundingType);

            $funding_type = $repository->find($model->funding_type_id);
            $model->billing_system_id = $funding_type->billing_system_id;
            $model->billing_cycle_id = $funding_type->billing_cycle_id;
            $model->payment_style_id = $funding_type->payment_style_id;
            $model->payment_channel_id = $funding_type->payment_channel_id;
            $model->sponsorship_type_id = $funding_type->sponsorship_type_id;
        });

        static::created(function ($model) {
            //Attach Patient to folder
            if (isset($model->reg_status) && $model->reg_status != 'WALK-IN') {
                $model->folders()->attach($model->folder_id);
                $folder = $model->folders()->orderBy('created_at', 'desc')->first();
                if (strtoupper($folder->folder_type) == 'FAMILY') {
                    $postFix = $folder->patients()->where('postfix', '!=', null)->max('postfix');

                    if ($postFix)
                        $postFix++;
                    else
                        $postFix = 'a';

                    $model->postfix = $postFix;
                    $model->save();
                }
            }
        });

        static::updating(function ($model) {
            try {
                $model->dob = DateHelper::toDBDate($model->dob);

                $model->id_expiry_date = DateHelper::toDBDate($model->id_expiry_date);


                $model->photo = FileResolver::base64ToFile($model->photo, $model->patient_id, 'patients' . DIRECTORY_SEPARATOR . 'photos') ?? null;

                //Passing the Billing References
                $repository = new RepositoryEloquent(new FundingType);
                $funding_type = $repository->find($model->funding_type_id);
                $model->billing_system_id = $funding_type->billing_system_id;
                $model->billing_cycle_id = $funding_type->billing_cycle_id;
                $model->payment_style_id = $funding_type->payment_style_id;
                $model->payment_channel_id = $funding_type->payment_channel_id;
                $model->sponsorship_type_id = $funding_type->sponsorship_type_id;


                $original = $model->getOriginal();

                if (isset($model->folder_id) && $original->folder_id != $model->folder_id) {
                    $model->folders()->detach($original->folder_id);

                    $folder = $model->folders()->orderBy('created_at', 'desc')->first();
                    if (strtoupper($folder->folder_type) == 'FAMILY') {
                        $postFix = $folder->patients()->where('postfix', '!=', null)->max('postfix');

                        if ($postFix)
                            $postFix++;
                        else
                            $postFix = 'a';

                        $model->postfix = $postFix;
                    }
                }

                if (isset($model->folder_id) && $model->folder_id) {
                    //Attach Patient to folder
                    $model->folders()->attach($model->folder_id);
                }
            } catch (Exception $e) {
            }
        });
    }

    public function title()
    {
        return $this->belongsTo(Title::class);
    }
    public function getAgeAttribute()
    {
        return  Carbon::parse($this->dob)->age;
    }

    public function getAbsAgeAttribute()
    {
        if ($age = Carbon::parse($this->dob)->diffInYears(Carbon::now())) {
            $this->age_unit = 'YEAR';
            return $age;
        } elseif ($age = Carbon::parse($this->dob)->diffInMonths(Carbon::now())) {
            $this->age_unit = 'MONTH';
            return $age;
        } elseif ($age = Carbon::parse($this->dob)->diffInWeeks(Carbon::now())) {
            $this->age_unit = 'WEEK';
            return $age;
        } else {
            $this->age_unit = 'DAY';
            return Carbon::parse($this->dob)->diffInDays(Carbon::now());
        }
    }

    public function ageByUnit(string $age_unit)
    {
        switch ($age_unit) {
            case 'YEAR':
                return Carbon::parse($this->dob)->diffInYears(Carbon::now());
            case 'MONTH':
                return Carbon::parse($this->dob)->diffInMonths(Carbon::now());
            case 'WEEK':
                return Carbon::parse($this->dob)->diffInWeeks(Carbon::now());
            case 'DAY':
                return Carbon::parse($this->dob)->diffInDays(Carbon::now());
        }
    }

    public function getAgeUnitAttribute()
    {
        if (!$this->age_unit)
            $this->absage;

        return $this->age_unit;
    }

    public function getFullNameAttribute()
    {
        return ucwords(trim($this->firstname . ' ' . $this->middlename) . ' ' . $this->surname);
    }

    public function getActiveFolderAttribute()
    {
        return $this->folders()->active()->orderBy('created_at', 'DESC')->first();
    }
    public function getOldFolderAttribute()
    {
        return $this->folders()->where('status', 'OLD')->orWhere('status', 'INACTIVE')->orderBy('created_at', 'DESC')->first();
    }
    public function folders()
    {
        return $this->belongsToMany(Folder::class, 'folder_patients');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'origin_country_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'origin_region_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'origin_district_id');
    }

    public function hometown()
    {
        return $this->belongsTo(Town::class, 'hometown_id');
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    public function emerg_relation()
    {
        return $this->belongsTo(Relationship::class, 'emerg_relation_id');
    }

    public function educational_level()
    {
        return $this->belongsTo(EducationalLevel::class);
    }

    public function id_type()
    {
        return $this->belongsTo(IdType::class);
    }

    public function funding_type()
    {
        return $this->belongsTo(FundingType::class, 'funding_type_id');
    }

    public function billing_system()
    {
        return $this->belongsTo(BillingSystem::class, 'billing_system_id');
    }

    public function billing_cycle()
    {
        return $this->belongsTo(BillingCycle::class, 'billing_cycle_id');
    }

    public function payment_style()
    {
        return $this->belongsTo(PaymentStyle::class, 'payment_style_id');
    }

    public function payment_channel()
    {
        return $this->belongsTo(PaymentChannel::class, 'payment_channel_id');
    }

    public function sponsorship_type()
    {
        return $this->belongsTo(SponsorshipType::class);
    }

    public function patient_sponsors()
    {
        return $this->hasMany(PatientSponsor::class);
    }

    public function native_language()
    {
        return $this->belongsTo(Language::class, 'native_lang_id');
    }

    public function second_language()
    {
        return $this->belongsTo(Language::class, 'second_lang_id');
    }

    public function official_language()
    {
        return $this->belongsTo(Language::class, 'official_lang_id');
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

     public function clinic_note_summary()
     {
         return $this->hasOne(PatientClinicalNoteSummary::class);
     }
}
