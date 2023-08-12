<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metodes extends Model
{
    protected $connection   = 'db_sales';
    protected $table        = 'metodes';
    protected $guarded      = ['id'];
    use HasFactory;
}
