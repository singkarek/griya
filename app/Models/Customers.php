<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customers extends Model
{
    protected $connection   = 'db_customers';
    protected $table        = 'customers';
    protected $guarded      = ['id'];
    use HasFactory;

    public function spliter():BelongsTo
    {
        return $this->belongsTo(Spliters::class, 'spliter_id', 'id');
    }
}
