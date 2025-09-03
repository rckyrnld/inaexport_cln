<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
	protected $primaryKey = 'id';

    protected $table = "csc_contact_us";
    
    protected $guarded = [];
}