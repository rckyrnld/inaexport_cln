<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomRoom extends Model
{
    protected $table = 'zoom_rooms';
    protected $guarded = [];

    // protected $appends = [
    //     'event_expired'
    // ];

    public function itdp_company_user()
    {
        return $this->belongsToMany(ItdpCompanyUser::class, 'zoom_participants', 'zoom_room_id', 'itdp_company_user_id')->withPivot('id','is_verified','attendance');
    }

    public function itdp_company_user_verified()
    {
        return $this->belongsToMany(ItdpCompanyUser::class, 'zoom_participants', 'zoom_room_id', 'itdp_company_user_id')->where('is_verified', true)->withPivot('id','is_verified','attendance');
    }

    public function itdp_company_user_exportir()
    {
        return $this->belongsToMany(ItdpCompanyUser::class, 'zoom_participants', 'zoom_room_id', 'itdp_company_user_id')->where('user_type', 'Supplier')->withPivot('id','is_verified','attendance');
    }

    public function itdp_company_user_exportir_verified()
    {
        return $this->belongsToMany(ItdpCompanyUser::class, 'zoom_participants', 'zoom_room_id', 'itdp_company_user_id')->where('user_type', 'Supplier')->where('is_verified', true)->withPivot('id','is_verified','attendance');
    }

    public function itdp_company_user_buyer()
    {
        return $this->belongsToMany(ItdpCompanyUser::class, 'zoom_participants', 'zoom_room_id', 'itdp_company_user_id')->where('user_type', 'Buyer')->withPivot('id','is_verified','attendance');
    }

    public function itdp_company_user_buyer_verified()
    {
        return $this->belongsToMany(ItdpCompanyUser::class, 'zoom_participants', 'zoom_room_id', 'itdp_company_user_id')->where('user_type', 'Buyer')->where('is_verified', true)->withPivot('id','is_verified','attendance');
    }

    public function itdp_admin_user()
    {
        return $this->belongsToMany(ItdpAdminUser::class, 'zoom_participants', 'zoom_room_id', 'itdp_admin_user_id')->withPivot('id','is_verified','attendance');
    }

    public function itdp_admin_user_verified()
    {
        return $this->belongsToMany(ItdpAdminUser::class, 'zoom_participants', 'zoom_room_id', 'itdp_admin_user_id')->where('is_verified', true)->withPivot('id','is_verified','attendance');
    }

    public function country()
    {
        return $this->belongsTo(MasterCountry::class, 'id_country', 'id');
    }

    // public function getEventExpiredAttribute()
    // {
    //     $return = false;
    //     $now = Carbon::now();
    //     $check_expired = (Carbon::parse($this->start_time)->addMinute($this->duration) > $now) ? false : true;
    //     $return = $check_expired;
    //     return $return;
    // }
}
