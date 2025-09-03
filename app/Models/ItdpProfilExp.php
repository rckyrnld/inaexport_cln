<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItdpProfilExp extends Model
{
    protected $table = 'itdp_profil_eks';
    protected $guarded = [];
    public $timestamps = false;

    public function company()
    {
        return $this->belongsTo(ItdpCompanyUser::class, 'id_profil', 'id')->where('id_role', 2);
    }

    public function contact_person()
    {
        return $this->hasMany(ItdpContactEks::class, 'id_itdp_profil_eks', 'id');
    }
}
