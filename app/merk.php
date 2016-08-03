<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class merk extends Model
{
	protected $table = 'merk';
    protected $fillable = array('nama', 'logo');
}
