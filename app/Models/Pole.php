<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pole extends Model
{
    protected $connection   = 'db_coverage';
    protected $table        = 'pole';
    protected $guarded      = ['id'];
    use HasFactory;
}
