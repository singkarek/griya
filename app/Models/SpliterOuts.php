<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpliterOuts extends Model
{
    protected $connection   = 'db_coverage';
    protected $table        = 'spliter_outs';
    protected $guarded      = ['id'];
    use HasFactory;
}
