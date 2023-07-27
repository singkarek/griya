<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiang extends Model
{
    protected $connection   = 'db_coverage';
    protected $table        = 'tiang';
    protected $guarded      = ['id'];
    use HasFactory;
}
