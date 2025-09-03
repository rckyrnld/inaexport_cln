<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notif extends Model
{
    protected $table = 'notif';
    protected $guarded = [];
    public $timestamps = false;
    
    public function admin()
    {
        return $this->belongsTo(ItdpAdminUser::class,'dari_id','id');
    }
    public function company()
    {
        return $this->belongsTo(ItdpCompanyUser::class,'dari_id','id');
    }
}
