<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsbWorkOrders extends Model
{
    protected $connection   = 'db_oprasional';
    protected $table        = 'psb_work_orders';
    protected $guarded      = ['id'];
    use HasFactory;
}
