<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    protected $fillable = array('nama', 'foto','tanggal', 'waktu', 'keterangan');
}
