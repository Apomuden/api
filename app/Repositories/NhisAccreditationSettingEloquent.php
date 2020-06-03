<?php
namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class NhisAccreditationSettingEloquent extends RepositoryEloquent implements INhisAccreditationSettingRepository{

    public function __construct(Model $model,$with=null)
    {
        parent::__construct($model,true,$with);
    }
    function first()
    {
        $key=$this->cache_prefix.'->first';
        if($this->with)
        $record= Cache::get($key)??$this->getModel()->with($this->with)->first();
        else
        $record= Cache::get($key)??$this->getModel()->first();
        return $this->cache($key,$record);
    }

    public function update(array $data,$id=null){
        $record=$this->first();
        $record->update($data);

        $key=$this->cache_prefix.'->first';

        return $this->cache($key,$record->refresh());
    }
}
