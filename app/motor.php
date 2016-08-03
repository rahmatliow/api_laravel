<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class motor extends Model
{
    protected $table = 'motor';
    protected $fillable = array('nama', 'foto', 'id_warna', 'id_merek', 'features', 'spec', 'service');
}
