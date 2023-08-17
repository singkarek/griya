<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProspectSegments extends Model
{
    protected $connection   = 'db_oprasional';
    protected $table        = 'prospects_segments';
    protected $guarded      = ['id'];
    use HasFactory;
}
