<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkTutorial extends Model
{
    protected $table = "link_tutorial";
    protected $guarded = [];

    public function type()
    {
        return $this->belongsTo(LinkTutorialUserType::class, 'link_tutorial_user_type_id');
    }
}
