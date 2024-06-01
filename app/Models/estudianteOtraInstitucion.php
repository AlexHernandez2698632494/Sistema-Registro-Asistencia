<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class estudianteOtraInstitucion extends Model
{
    use HasFactory;
    protected $table = 'estudianteInstitucion';
    protected $primaryKey = 'idInstitucion';
    public $timestamps = false;
}
