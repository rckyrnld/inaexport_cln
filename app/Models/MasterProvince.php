<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterProvince extends Model
{
	protected $primaryKey = 'id';

    protected $table = "mst_province";
    
    protected $guarded = [];
}