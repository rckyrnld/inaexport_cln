<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoConference extends Model
{
    protected $table = 'video_conferences';
    protected $guarded = [];

    // protected $appends = [
    //     'event_expired'
    // ];

    public function itdp_company_user()
    {
        return $this->belongsToMany(ItdpCompanyUser::class, 'video_conference_participants', 'video_conference_id', 'itdp_company_user_id');
    }

    public function itdp_company_user_exportir()
    {
        return $this->belongsToMany(ItdpCompanyUser::class, 'video_conference_participants', 'video_conference_id', 'itdp_company_user_id')->where('user_type', 'Supplier');
    }

    public function itdp_company_user_buyer()
    {
        return $this->belongsToMany(ItdpCompanyUser::class, 'video_conference_participants', 'video_conference_id', 'itdp_company_user_id')->where('user_type', 'Buyer');
    }

    public function itdp_admin_user()
    {
        return $this->belongsToMany(ItdpAdminUser::class, 'video_conference_participants', 'video_conference_id', 'itdp_admin_user_id');
    }

    public function video_conference_participants()
    {
        return $this->hasMany(VideoConferenceParticipant::class, 'video_conference_id', 'id');
    }
}
