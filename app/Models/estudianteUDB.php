<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class estudianteUDB extends Model
{
    use HasFactory;
    protected $table = 'estudianteUDB';
    protected $primaryKey = 'idUDB';
    public $timestamps = false;
}
