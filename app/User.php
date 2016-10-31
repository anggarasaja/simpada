<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = "operator";
    protected $primaryKey  = 'opr_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'opr_user', 'opr_passwd', 'opr_status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'opr_passwd',
    ];

    public function getAuthPassword(){
        return $this->opr_passwd;
    }
}
