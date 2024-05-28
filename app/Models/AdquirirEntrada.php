<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdquirirEntrada extends Model
{
    use HasFactory;

    protected $table = 'adquirirEntrada';
    protected $primarykey = 'idAdquirirEntrada';
    public $timestamps = false;
}
