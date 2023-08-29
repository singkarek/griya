<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $connection   = 'db_sales';
    protected $table        = 'providers';
    use HasFactory;
}
