<?php

namespace App\Listeners;

use App\Events\BeforeAudit;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use OwenIt\Auditing\Events\Auditing;

class AuditingListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BeforeAudit  $event
     * @return void
     */
    public function handle(Auditing $event)
    {
        try{
            $original = $event->model->getOriginal();
            $current = $event->model->toArray();
            unset($current['updated_at'], $original['updated_at']);
            return $original != $current;
        }
        catch(Exception $e){
             return true;
        }
    }
}
