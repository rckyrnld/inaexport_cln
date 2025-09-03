<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventInterest extends Model
{
    protected $primaryKey = 'id';

    protected $table = "event_interest";

    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(ItdpCompanyUser::class, 'id_profile', 'id_profil')->where('id_role', 2);
    }

    public function buyer()
    {
        return $this->belongsTo(ItdpCompanyUser::class, 'id_profile', 'id_profil')->where('id_role', 3);
    }
}
