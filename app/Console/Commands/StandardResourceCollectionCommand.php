<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class StandardResourceCollectionCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:standardCollection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Resource Collection based on the standard used by the Apomuden Backend Team';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Collection';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/Stubs/collection.standard.stub';
    }

    protected function replaceClass($stub, $name)
    {
        $name = str_replace('Collection','', $name);
        return parent::replaceClass($stub, $name); // TODO: Change the autogenerated stub
    }

    protected function getPath($name)
    {
        $name = Str::endsWith($name, 'Collection')?$name:$name.'Collection';
        return parent::getPath($name); // TODO: Change the autogenerated stub
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Resources';
    }
}