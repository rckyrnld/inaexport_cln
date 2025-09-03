<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomParticipant extends Model
{
    protected $table = 'zoom_participants';
    protected $guarded = [];

    public function zoom_room()
    {
        return $this->belongsTo(ZoomRoom::class, 'zoom_room_id', 'id');
    }
}
