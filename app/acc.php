<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class acc extends Model
{
    protected $table = 'acc';
    protected $fillable = array('nama','id_motor', 'keterangan');
}
