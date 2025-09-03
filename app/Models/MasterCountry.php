<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterCountry extends Model
{
	protected $primaryKey = 'id';

    protected $table = "mst_country";
    
    protected $guarded = [];
}