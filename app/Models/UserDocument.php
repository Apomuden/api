<?php

namespace App\Models;

use App\Http\Helpers\FileResolver;
use App\Http\Traits\Eloquent\ActiveTrait;
use App\Repositories\RepositoryEloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDocument extends Model
{
    use ActiveTrait, SoftDeletes;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $userRepo = new RepositoryEloquent(new User);
            $username = $userRepo->findOrFail($model->user_id)->username;
            $model->file = FileResolver::base64ToFile($model->file, $username . '-' . uniqid(), 'users' . DIRECTORY_SEPARATOR . 'files') ?? null;
        });

        static::updating(function ($model) {
            $userRepo = new RepositoryEloquent(new User);
            $username = $userRepo->findOrFail($model->user_id)->username;
            $uploadDir = 'users' . DIRECTORY_SEPARATOR . 'files';
            $model->file = FileResolver::base64ToFile($model->file, $username . '-' . uniqid(), $uploadDir) ?? null;
            if ($model->file) {
                $originalModel = $model->getOriginal();
                FileResolver::unlink($originalModel['file'], $model->file, $uploadDir);
            }
        });
    }
}
