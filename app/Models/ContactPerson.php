<?php

namespace App\Models;

use App\Models\EventInterest;
use Illuminate\Database\Eloquent\Model;

class ContactPerson extends Model
{
    protected $primaryKey = 'id';

    protected $table = "contact_person";

    protected $guarded = [];
}
