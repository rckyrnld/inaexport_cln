<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
	protected $primaryKey = 'id_log';

    protected $table = "log_user";
    
    protected $guarded = [];
}