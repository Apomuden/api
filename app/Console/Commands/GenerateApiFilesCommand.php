<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class GenerateApiFilesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:apifiles {name} {--m|migration} {--t|table=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate all standard (as used by Apomuden Backend team) api files with a single command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() : void
    {
        $className = $this->argument('name');

        $this->info('Answer a few questions to get started...');
        $ModelName = $this->ask('Model Name (Default: App\Models\\'.$className.')')??$className;
        $ControllerName = $this->ask('Controller Name (Default: App\Http\Controllers\\'.$className.'Controller)')??$className.'Controller';
        $RequestName = $this->ask('Request Name (Default: App\Http\Requests\\'.$className.'Request)')??$className.'Request';
        $ResourceName = $this->ask('Resource Name (Default: App\Http\Resources\\'.$className.'Resource)')??$className.'Resource';
        $CollectionName = $this->ask('Collection Name (Default: App\Http\Resources\\'.$className.'Collection)')??$className.'Collection';

        $classNameUnderscore = Str::snake(Str::pluralStudly($className));
        $tableName = $this->option('table')??$classNameUnderscore;
        if ($this->option('migration')) {
            $this->line('Creating Migration...');
            Artisan::call('make:migration create_' . $classNameUnderscore . '_table');
            $this->info('Migration created successfully');
        }
        Artisan::call('make:standardModel '.$ModelName);
        $this->info('Model created successfully');
        Artisan::call('make:standardRequest '.$RequestName.' -t '.$tableName);
        $this->info('Request created successfully');
        Artisan::call('make:standardResource '.$ResourceName.' -t '.$tableName);
        $this->info('Resource created successfully');
        Artisan::call('make:standardCollection '.$CollectionName);
        $this->info('Resource Collection created successfully');
        Artisan::call('make:standardController '.$ControllerName);
        $this->info('Controller created successfully');
        $this->comment('You are all set! :)');
    }
}
