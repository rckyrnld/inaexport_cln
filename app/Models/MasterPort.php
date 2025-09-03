<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterPort extends Model
{
	protected $primaryKey = 'id';

    protected $table = "mst_port";
    
    protected $guarded = [];
}