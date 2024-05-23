<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class administrador extends Model
{
    use HasFactory;
    protected $table = 'administrador';
    protected $primarykey = 'idAdmin';
    public $timestamps = false;
}
