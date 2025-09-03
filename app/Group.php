<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	 public $table = 'group';
	 public $primaryKey = 'id_group';
	 
     protected $fillable = [
        'group_name', 'created_at', 'updated_at','id_group'
    ];
}
