<?php

namespace App\Models;

use App\Events\BeforeAudit;
use App\Listeners\AuditingListener;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Events\Auditing;

class AuditableModel extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    // public function audit_trails()
    // {
    //     return $this->morphMany(Audit::class, 'auditable');
    // }
}
