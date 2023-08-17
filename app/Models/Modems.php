<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modems extends Model
{
    protected $connection = 'db_warehouse';
    protected $table = 'modems';
    protected $guarded = ['id'];
    use HasFactory;
}
