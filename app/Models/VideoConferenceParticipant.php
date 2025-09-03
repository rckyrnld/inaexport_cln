<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoConferenceParticipant extends Model
{
    protected $table = 'video_conference_participants';
    protected $guarded = [];

    public function video_conference()
    {
        return $this->belongsTo(VideoConference::class, 'video_conference_id', 'id');
    }
    
}
