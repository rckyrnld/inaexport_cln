<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterCity extends Model
{
	protected $primaryKey = 'id';

    protected $table = "mst_city";
    
    protected $guarded = [];
}