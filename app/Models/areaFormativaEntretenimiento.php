<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class areaFormativaEntretenimiento extends Model
{
    use HasFactory;

    protected $table = 'areaFormativaEntretenimiento';
    protected $primarykey = 'idAreaFormativaEntretenimiento';
    public $timestamps = false;
}
