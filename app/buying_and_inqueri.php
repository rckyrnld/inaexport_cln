<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class buying_and_inqueri extends Model
{
    //
    protected $table = 'v_csc_all_inquiry_br';
    protected $guarded = [];
}
