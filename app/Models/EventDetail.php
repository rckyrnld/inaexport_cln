<?php

namespace App\Models;

use App\Models\EventInterest;
use Illuminate\Database\Eloquent\Model;

class EventDetail extends Model
{
    protected $primaryKey = 'id';

    protected $table = "event_detail";

    protected $guarded = [];

    public function participants()
    {
        return $this->hasMany(EventInterest::class, 'id_event', 'id');
    }

    public function contact_person()
    {
        return $this->hasMany(ContactPerson::class, 'id_type', 'id');
    }

    public function country_name()
    {
        return $this->belongsTo(MasterCountry::class, 'country','id');
    }
}
