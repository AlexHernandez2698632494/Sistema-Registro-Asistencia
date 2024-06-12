<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventEntry extends Model
{
    use HasFactory;
    protected $table = 'eventEntry';
    protected $primaryKey = 'idEventEntry';
    public $timestamps = false;
}
