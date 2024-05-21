<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class areaFormativaEntretenimientoEvento extends Model
{
    use HasFactory;

    protected $table = 'areaFormativaEntretenimientoEvento';
    protected $primarykey = 'idDetalle';
    public $timestamps = false;
}
