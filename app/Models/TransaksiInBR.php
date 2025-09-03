<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiInBR extends Model
{
	protected $primaryKey = 'id_transaksi';

    protected $table = "csc_transaksi";
    
    protected $guarded = [];

	protected $fillable = ['id_pembuat','by_role','id_eksportir','id_terkait','origin','type_tracking','no_tracking','created_at','status_transaksi','eo','neo','tp','ntp','total']; 

	public $timestamps = false;
}