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
   public function all()
   {
       if($this->useCache)
         return Cache::get($this->cache_prefix.'->all')??($this->useActiveTrait?$this->model->active()->get():$this->model->all());
       else
         return ($this->useActiveTrait?$this->model->active()->get():$this->model->all());
   }

   // create a new record in the database
   public function store(array $data)
   {
       return $this->model->forceCreate($data);
   }

   // update record in the database
   public function update(array $data, $id)
   {
       $record = $this->model->find($id);
       $record= $record->update($data);
       return $record;
   }

   // remove record from the database
   public function delete($id)
   {
       return $this->model->destroy($id);
   }

   // show the record with the given id
   public function show($id)
   {
       if($this->useCache)
           return Cache::get($this->cache_prefix.'->find->'.$id)??$this->model->find($id);
       else
           return $this->model->findOrFail($id);
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
}
