<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class RegionEloquent extends RepositoryEloquent
{


    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
