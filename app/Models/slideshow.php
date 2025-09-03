<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class slideshow extends Model
{
    protected $primaryKey = 'id';

    protected $table = "slideshows";

    protected $fillable = [
        'nama',
        'status',
    ];
}
