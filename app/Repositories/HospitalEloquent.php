<?php
namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;

class HospitalEloquent extends RepositoryEloquent implements IHospitalRepository{

    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
    function first()
    {
       return $this->model->first();
    }
}
