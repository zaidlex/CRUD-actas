<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acta extends Model
{
    public $table = 'Acta';
    protected $guarded = ["ActaID"];
    public $timestamps = false;
}
