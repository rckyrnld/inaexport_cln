<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuyingRequest extends Model
{
    //
    protected $table = 'csc_buying_request';
    protected $guarded = [];
    public $timestamps = false;
}
