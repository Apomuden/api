<?php
namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;

class CountryEloquent extends RepositoryEloquent implements IHospitalRepository{

    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
