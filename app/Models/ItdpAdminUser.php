<?php

namespace App\Models;

use App\Group;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItdpAdminUser extends Model
{
    protected $table = 'itdp_admin_users';
    protected $guarded = [];

    public function zoom_rooms()
    {
        return $this->belongsToMany(ZoomRoom::class, 'zoom_participants', 'itdp_admin_user_id', 'zoom_room_id');
    }

    public function profile_perwadag_ln()
    {
        return $this->hasOne(ItdpAdminLn::class, 'id', 'id_admin_ln');
    }

    public function profile_perwadag_dn()
    {
        return $this->hasOne(ItdpAdminDn::class, 'id', 'id_admin_dn');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'id_group', 'id_group');
    }
}
