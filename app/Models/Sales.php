<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $connection   = 'db_sales';
    protected $table        = 'prospects';
    protected $guarded      = ['id'];
    use HasFactory;
}
