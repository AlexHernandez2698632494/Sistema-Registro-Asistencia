<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntradaG extends Model
{
    use HasFactory;
    protected $table = 'eventEntries';
    protected $primaryKey = 'idEventEntries';
    public $timestamps = false;
}
