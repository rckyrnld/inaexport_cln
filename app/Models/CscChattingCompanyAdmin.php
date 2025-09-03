<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CscChattingCompanyAdmin extends Model
{
    protected $table = "csc_chatting_company_admin";
    protected $guarded = [];

    public function admin_user()
    {
        return $this->hasOne(ItdpAdminUser::class, 'id', 'id_admin');
    }

    public function company_user()
    {
        return $this->hasOne(ItdpCompanyUser::class, 'id', 'id_eks_imp');
    }

    public function other_admin_user()
    {
        return $this->hasOne(ItdpAdminUser::class, 'id', 'id_other_admin');
    }
}
