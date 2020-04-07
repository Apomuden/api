<?php

use App\Models\AgeCategory;
use App\Models\AgeClassification;
use App\Models\AgeGroup;
use App\Repositories\RepositoryEloquent;
use Illuminate\Database\Seeder;

class AgeClassificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $repository;
    public function run()
    {
      $this->repository =new RepositoryEloquent(new AgeClassification);
      $name= 'GHS STATEMENT OF OUT PATIENT';
      if(!($age_class=$this->repository->findWhere(['name'=>$name])->first())){
            $age_class = $this->repository->store([
                'name' => 'GHS STATEMENT OF OUT PATIENT'
            ]);
            $age_class = $age_class->refresh();
      }

      $this->repository=new RepositoryEloquent(new AgeCategory);
      $this->repository->store([
        'age_classification_id'=>$age_class->id,
        'description'=>'0-28 days',
        'min_age'=>0,
        'min_unit'=>'DAY',
        'min_comparator'=>'>=',
        'max_age'=>28,
        'max_comparator'=>"<=",
        'max_unit'=>'DAY',
        'age_group_id'=>(new RepositoryEloquent(new AgeGroup))
                     ->findWhere(['name'=>'baby'])->first()->id??null

      ]);

        $this->repository->store([
            'age_classification_id' => $age_class->id,
            'description' => '1-11 months',
            'min_age' => 1,
            'min_unit' => 'MONTH',
            'min_comparator' => '>=',
            'max_age' => 11,
            'max_comparator' => "<=",
            'max_unit' => 'MONTH',
            'age_group_id' => (new RepositoryEloquent(new AgeGroup))
                ->findWhere(['name' => 'infant'])->first()->id ?? null

        ]);

        $this->repository->store([
            'age_classification_id' => $age_class->id,
            'description' => '1-4 years',
            'min_age' => 1,
            'min_unit' => 'YEAR',
            'min_comparator' => '>=',
            'max_age' => 4,
            'max_comparator' => "<=",
            'max_unit' => 'YEAR',
            'age_group_id' => (new RepositoryEloquent(new AgeGroup))
                ->findWhere(['name' => 'child'])->first()->id ?? null

        ]);
        $this->repository->store([
            'age_classification_id' => $age_class->id,
            'description' => '5-9 years',
            'min_age' => 5,
            'min_unit' => 'YEAR',
            'min_comparator' => '>=',
            'max_age' => 9,
            'max_comparator' => "<=",
            'max_unit' => 'YEAR',
            'age_group_id' => (new RepositoryEloquent(new AgeGroup))
                ->findWhere(['name' => 'child'])->first()->id ?? null

        ]);
        $this->repository->store([
            'age_classification_id' => $age_class->id,
            'description' => '10-14 years',
            'min_age' =>10,
            'min_unit' => 'YEAR',
            'min_comparator' => '>=',
            'max_age' => 14,
            'max_comparator' => "<=",
            'max_unit' => 'YEAR',
            'age_group_id' => (new RepositoryEloquent(new AgeGroup))
                ->findWhere(['name' => 'child'])->first()->id ?? null

        ]);
        $this->repository->store([
            'age_classification_id' => $age_class->id,
            'description' => '15-17 years',
            'min_age' =>15,
            'min_unit' => 'YEAR',
            'min_comparator' => '>=',
            'max_age' => 17,
            'max_comparator' => "<=",
            'max_unit' => 'YEAR',
            'age_group_id' => (new RepositoryEloquent(new AgeGroup))
                ->findWhere(['name' => 'child'])->first()->id ?? null

        ]);
        $this->repository->store([
            'age_classification_id' => $age_class->id,
            'description' => '18-19 years',
            'min_age' =>18,
            'min_unit' => 'YEAR',
            'min_comparator' => '>=',
            'max_age' => 19,
            'max_comparator' => "<=",
            'max_unit' => 'YEAR',
            'age_group_id' => (new RepositoryEloquent(new AgeGroup))
                ->findWhere(['name' => 'adult'])->first()->id ?? null

        ]);
        $this->repository->store([
            'age_classification_id' => $age_class->id,
            'description' => '20-34 years',
            'min_age' =>20,
            'min_unit' => 'YEAR',
            'min_comparator' => '>=',
            'max_age' => 34,
            'max_comparator' => "<=",
            'max_unit' => 'YEAR',
            'age_group_id' => (new RepositoryEloquent(new AgeGroup))
                ->findWhere(['name' => 'adult'])->first()->id ?? null

        ]);
        $this->repository->store([
            'age_classification_id' => $age_class->id,
            'description' => '35-49 years',
            'min_age' =>35,
            'min_unit' => 'YEAR',
            'min_comparator' => '>=',
            'max_age' => 49,
            'max_comparator' => "<=",
            'max_unit' => 'YEAR',
            'age_group_id' => (new RepositoryEloquent(new AgeGroup))
                ->findWhere(['name' => 'Middle-Aged Adult'])->first()->id ?? null

        ]);
        $this->repository->store([
            'age_classification_id' => $age_class->id,
            'description' => '50-59 years',
            'min_age' =>50,
            'min_unit' => 'YEAR',
            'min_comparator' => '>=',
            'max_age' => 59,
            'max_comparator' => "<=",
            'max_unit' => 'YEAR',
            'age_group_id' => (new RepositoryEloquent(new AgeGroup))
                ->findWhere(['name' => 'Old Adult'])->first()->id ?? null

        ]);
        $this->repository->store([
            'age_classification_id' => $age_class->id,
            'description' => '60-69 years',
            'min_age' => 60,
            'min_unit' => 'YEAR',
            'min_comparator' => '>=',
            'max_age' => 69,
            'max_comparator' => "<=",
            'max_unit' => 'YEAR',
            'age_group_id' => (new RepositoryEloquent(new AgeGroup))
                ->findWhere(['name' => 'Old Adult'])->first()->id ?? null

        ]);

        $this->repository->store([
            'age_classification_id' => $age_class->id,
            'description' => '70 Yrs & Above',
            'min_age' => 70,
            'min_unit' => 'YEAR',
            'min_comparator' => '>=',
            //'max_age' => 69,
            //'max_comparator' => "<=",
            'max_unit' => 'YEAR',
            'age_group_id' => (new RepositoryEloquent(new AgeGroup))
                ->findWhere(['name' => 'Old Adult'])->first()->id ?? null

        ]);
    }
}
