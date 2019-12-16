<?php
namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;
use Illuminate\Support\Facades\Cache;
use App\Http\Traits\ActiveTrait;


class RepositoryEloquent implements IRepository{
   // model property on class instances
   protected $model,$cache_prefix,$useCache=true,$useActiveTrait;

   // Constructor to bind model to repo
   public function __construct(Model $model,bool $useCache=true)
   {
       $this->model = $model;
       $this->cache_prefix=$this->cache_prefix??class_basename($this->model);
       $this->useCache=$useCache;
       $this->useActiveTrait=in_array(ActiveTrait::class, class_uses($this->model));
   }

   // Get all instances of model
   public function all($sortBy=null)
   {
       $key=$this->cache_prefix.'->all';
       if($this->useCache){
            $all= Cache::get($key);
            if($all)
            return $all;
            $all=$this->useActiveTrait?$this->model->active()->get():$this->model->all();
       }
       else
         $all= ($this->useActiveTrait?$this->model->active()->get():$this->model->all());

         $all=$all && $sortBy?$all->sortBy($sortBy):$all;

         return $this->cache($key,$all);
   }

   public function paginate($paginate=15,$sortBy=null){
         $key=$this->cache_prefix.'->paginate::'.$paginate;
        if($this->useCache){
           $all= Cache::get($key);
           if($all)
           return $all;
           $all=$this->useActiveTrait?$this->model->active():$this->model;
        }
        else
          $all= ($this->useActiveTrait?$this->model->active():$this->model);

          $all=$all && $sortBy?$all->orderBy($sortBy):$all;

         $all=$all->paginate($paginate);

         return $this->cache($key,$all);
   }

   // create a new record in the database
   public function store(array $data)
   {
       return $this->model->forceCreate($data);
   }

   // update record in the database
   public function update(array $data, $id)
   {
       $record = $this->model->findOrFail($id);
       $record->update($data);
       return $record->refresh();
   }

   // remove record from the database
   public function delete($id)
   {
       return $this->model->destroy($id);
   }

   // show the record with the given id
   public function show($id)
   {
       $key=$this->cache_prefix.'->find->'.$id;
       if($this->useCache){
           $record= Cache::get($key);
           if($record)
           return $record;
           $record=$this->model->find($id);
       }
       else{
           $record=$this->model->findOrFail($id);
       }

       return $this->cache($key,$record);
   }

   public function find($id){
      return $this->show($id);
   }

   // Get the associated model
   public function getModel()
   {
       return $this->model;
   }

   // Set the associated model
   public function setModel($model)
   {
       $this->model = $model;
      // return $this;
   }

   // Eager load database relationships
   public function with($relations)
   {
       return $this->model->with($relations);
   }

   protected function cache($key,$value){
    Cache::forever($key,$value);
    return $value;
   }

}
