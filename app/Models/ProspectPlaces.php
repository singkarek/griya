<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProspectPlaces extends Model
{
    protected $connection   = 'db_oprasional';
    protected $table        = 'prospects_places';
    protected $guarded      = ['id'];
    use HasFactory;
}
