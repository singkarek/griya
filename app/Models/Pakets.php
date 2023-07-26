<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pakets extends Model
{
    protected $connection = 'db_company';
    protected $table = 'service_packages';
    protected $guarded = ['id'];
    use HasFactory;
}
