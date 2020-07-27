<?php

namespace App\Jobs;

use App\Http\Helpers\AmasamanMigration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AmasamanMigrationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $patient;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($patient)
    {
        $this->patient=$patient;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new AmasamanMigration)->createPatient($this->patient);
    }
}
