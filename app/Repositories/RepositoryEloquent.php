<?php
namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;
use Illuminate\Support\Facades\Cache;
use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RepositoryEloquent implements IRepository{
   // model property on class instances
   protected $model,$cache_prefix,$useCache=true;
   public $useActiveTrait=false,$useFindBy;

   // Constructor to bind model to repo
   public function __construct(Model $model,bool $useCache=true,$with=null)
   {
       $this->model = $model;
       $this->with=$with;

       $this->cache_prefix=$this->cache_prefix??class_basename($this->model);
       $this->useCache=$useCache;
       //$this->useActiveTrait=in_array(ActiveTrait::class, class_uses($this->model));
       $this->useFindBy=in_array(FindByTrait::class, class_uses($this->model));
   }

   // Get all instances of model
   public function all($sortBy=null, $sortOrder='ASC')
   {
       $key=$this->cache_prefix.'->all';
       $searchParams=\request()->query();

       unset($searchParams['sortBy']);
       unset($searchParams['order']);

       if($this->useCache){
            $all= Cache::get($key);
            if(!$searchParams && $all)
               return $all;
            if($this->with){
                $all=$this->useActiveTrait?$this->model->with($this->with)->active():$this->model->with($this->with);
                $all=($this->useFindBy && $searchParams)?$all->findBy($searchParams):$all;
                $all=$all->latest()->get();
            }
            else{
                $all=$this->useActiveTrait?$this->model->active():$this->model;
                $all=($this->useFindBy && $searchParams)?$all->findBy($searchParams):$all;
                $all=$all->latest()->get();
            }
       }
       else{
           if($this->with){
               $all= ($this->useActiveTrait?$this->model->with($this->with)->active():$this->model->with($this->with));
               $all=($this->useFindBy && $searchParams)?$all->findBy($searchParams):$all;
                $all = $all->latest()->get();
           }
           else{
               $all= ($this->useActiveTrait?$this->model->active():$this->model);
               $all=($this->useFindBy && $searchParams)?$all->findBy($searchParams):$all;
                $all = $all->latest()->get();
           }
       }

       if ($sortOrder=='DESC') {
           $all = $all && $sortBy ? $all->sortByDesc($sortBy) : $all;
       }
       else {
           $all = $all && $sortBy ? $all->sortBy($sortBy) : $all;
       }


         return $this->cache($key,$all);
   }

   public function paginate($paginate=15,$sortBy=null,$order='ASC'){

        //Get the sort from the route params
        $urlSortBy=\request()->input('sortBy');
        $urlOrder=\request()->input('order');
        $sortBy=$urlSortBy??$sortBy;
        $order=$urlOrder??$order;

        $searchParams=\request()->query();

        unset($searchParams['sortBy']);
        unset($searchParams['order']);


         $key=$this->cache_prefix.'->paginate';

        if(!$urlSortBy & $this->useCache){
           $all=Cache::get($key);
           if(!$searchParams && $all)
           return $all;

           if($this->with)
              $all=$this->useActiveTrait?$this->model->with($this->with)->active():$this->model->with($this->with);
           else
              $all=$this->useActiveTrait?$this->model->active():$this->model;
        }
        else{
            if($this->with)
              $all= ($this->useActiveTrait?$this->model->with($this->with)->active():$this->model->with($this->with));
            else
              $all= ($this->useActiveTrait?$this->model->active():$this->model);
        }

          $all=$all && $sortBy?$all->orderBy($sortBy,$order):$all;

         $all=($this->useFindBy && $searchParams)?$all->findBy($searchParams):$all;

         $all=$all->paginate($paginate);

         return $this->cache($key,$all);
   }

   // create a new record in the database
   public function store(array $data)
   {
        //Delete Previous cached value
        $this->deletCache();

       $record=$this->model->forceCreate($data);

       //Recache and return new value
       $key=$this->cache_prefix.'->find->'.$record->id;

       return $this->cache($key,$record);
   }

   // update record in the database
   public function update(array $data, $id)
   {
       $key=$this->cache_prefix.'->find->'.$id;
       $record = $this->model->findOrFail($id);
       $record->update($data);

       //Delete Previous cached value
       $this->deletCache($key);

       $record=$record->refresh();
       //Recache and return new value
       return $this->cache($key,$record);
   }

   // remove record from the database
   public function delete($id)
   {
       $key=$this->cache_prefix.'->find->'.$id;
       //Delete Previous cached value
       $this->deletCache($key);
       return $this->model->destroy($id);
   }

   // first the record with the given id
   public function first()
   {

       $key=$this->cache_prefix.'->first';

       if($this->useCache){
           $record= Cache::get($key);
           if($record)
           return $record;

           if($this->with)
           $record=$this->model->with($this->with)->first();
           else
           $record=$this->model->first();
       }
       else{
           if($this->with)
           $record=$this->model->with($this->with)->first();
           else
           $record=$this->model->first();
       }

       return $this->cache($key,$record);
   }
    // count the record with the given id
    public function count()
    {

        $key = $this->cache_prefix . '->count';

        if ($this->useCache) {
            $record = Cache::get($key);
            if ($record)
                return $record;

            if ($this->with)
                $record = $this->model->with($this->with)->count();
            else
                $record = $this->model->count();
        } else {
            if ($this->with)
                $record = $this->model->with($this->with)->count();
            else
                $record = $this->model->count();
        }

        return $this->cache($key, $record);
    }
   // show the record with the given id
   public function show($id)
   {

       $key=$this->cache_prefix.'->find->'.$id;

       if($this->useCache){
           $record= Cache::get($key);
           if($record)
           return $record;

           if($this->with)
           $record=$this->model->with($this->with)->find($id);
           else
           $record=$this->model->find($id);
       }
       else{
           if($this->with)
           $record=$this->model->with($this->with)->find($id);
           else
           $record=$this->model->find($id);
       }

       return $this->cache($key,$record);
   }

   //find record by
   public function showWhere(array $where)
   {
           if($this->with)
           $record=$this->model->with($this->with)->where($where);
           else
           $record=$this->model->where($where);

       return $record;
   }


   public function findOrFail($id)
   {
       $key=$this->cache_prefix.'->find->'.$id;
       if($this->useCache){
           $record= Cache::get($key);
           if($record)
           return $record;

           if($this->with)
           $record=$this->model->with($this->with)->findOrFail($id);
           else
           $record=$this->model->findOrFail($id);
       }
       else{
           if($this->with)
           $record=$this->model->with($this->with)->findOrFail($id);
           else
           $record=$this->model->findOrFail($id);
       }

       return $this->cache($key,$record);
   }

   public function find($id){
      return $this->show($id);
   }

   public function findWhere($where){
      return $this->showWhere($where);
   }

   // Get the associated model
   public function getModel()
   {
       return $this->model;
   }

   // Set the associated model
   public function setModel($model,$with=null)
   {
       $this->model = $model;
       if($with)
       $this->with=$with;
       $this->cache_prefix=class_basename($this->model);

      // return $this;
   }

   // Eager load database relationships
   public function with($relations)
   {
       return $this->model->with($relations);
   }

   public function getInstanceWith($with){
       if($with){
        $this->with($with);
       }
       return $this;
   }

   protected function cache($key,$value,$time=null){
        if($time)
        Cache ::put($key,$value ,$time);
        else
        Cache::forever($key,$value);

        $searchParams=\request()->query();

        if($searchParams)
        $this->deletCache($key);

        return $value;
   }

   protected function deletCache($key=null){

       /*if($key)
         Cache::forget($key);

        //Delete the all
        $key=$this->cache_prefix.'->all';
        Cache::forget($key);

        //Delete the paginate
        $key=$this->cache_prefix.'->paginate';
        Cache::forget($key);*/

        Artisan::call('cache:clear');
   }

}
