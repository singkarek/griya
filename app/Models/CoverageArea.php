<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoverageArea extends Model
{
    protected $connection = 'db_coverage';
    protected $guarded = ['id'];
    use HasFactory;
}
