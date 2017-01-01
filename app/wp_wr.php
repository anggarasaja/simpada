<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class wp_wr extends Model
{
    protected $table = 'wp_wr';
    public $timestamps = false;
    protected $primaryKey = 'wp_wr_id';
}
