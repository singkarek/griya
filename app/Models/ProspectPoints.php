<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProspectPoints extends Model
{
    protected $connection   = 'db_oprasional';
    protected $table        = 'prospects_points';
    protected $guarded      = ['id'];
    use HasFactory;
}
