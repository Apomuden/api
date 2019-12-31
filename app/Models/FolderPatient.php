<?php

namespace App\Models;

use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;

class FolderPatient extends Model
{
    use FindByTrait;
    protected $guarded = [];
}
