<?php

namespace App;

use App\Models\ItdpProfilExp;
use App\Models\ItdpProfilImp;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Eksmp extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'itdp_company_users';
    protected $fillable = [
        'username', 'email', 'password', 'id_role', 'id_profil'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne(ItdpProfilExp::class, 'id', 'id_profil');
    }

    public function profile_buyer()
    {
        return $this->hasOne(ItdpProfilImp::class, 'id', 'id_profil');
    }
}
