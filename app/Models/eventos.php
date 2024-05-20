<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class eventos extends Model
{
    use HasFactory;

    protected $table = 'eventos';
    protected $primaryKey = 'idEvento';
        public $timestamps = false;
}
