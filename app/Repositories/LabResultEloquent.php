<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CountryEloquent extends RepositoryEloquent
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
