<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Placement extends Model
{
    protected $connection   = 'db_coverage';
    protected $table        = 'placements';
    protected $guarded      = ['id'];
    use HasFactory;
}
