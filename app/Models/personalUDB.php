<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class personalUDB extends Model
{
    use HasFactory;

    protected $table = 'personalUDB';
    protected $primaryKey = 'idUDB';
    public $timestamps = false;
}
