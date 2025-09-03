<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItdpProfilImp extends Model
{
    protected $table = 'itdp_profil_imp';
    protected $guarded = [];

    public function company()
    {
        return $this->belongsTo(ItdpCompanyUser::class, 'id_profil', 'id')->where('id_role', 3);
    }

    public function country()
    {
        return $this->belongsTo(MasterCountry::class, 'id', 'id_mst_country');
    }
}
