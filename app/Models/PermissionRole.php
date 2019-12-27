<?php

namespace App\Models;

use App\Repositories\RepositoryEloquent;
use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
           
        });

        static::deleted(function($model){
            $repository=new RepositoryEloquent(new PermissionUser);
            $users=$repository->findWhere(['role_id'=>$model->role_id])->get();

            foreach($users as $user){
                PermissionUser::where(['user_id'=>$user->id,'permission_id'=>$model->permission_id])->delete();
            }
        });
    }

}
