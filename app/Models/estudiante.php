<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class estudiante extends Model
{
    use HasFactory;

    protected $table = 'Estudiante';
    protected $primaryKey = 'idEstudiante';
        public $timestamps = false;

}
