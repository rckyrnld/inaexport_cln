<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItdpAdminLn extends Model
{
    protected $table = 'itdp_admin_ln';
    protected $guarded = [];

    public function country_name()
    {
        return $this->hasOne(MasterCountry::class, 'id', 'country');
    }
}
