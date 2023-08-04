<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spliters extends Model
{
    protected $connection   = 'db_coverage';
    protected $table        = 'spliters';
    protected $guarded      = ['id'];
    use HasFactory;
}
