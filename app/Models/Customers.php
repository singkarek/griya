<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customers extends Model
{
    protected $connection   = 'db_customers';
    protected $table        = 'customers';
    protected $guarded      = ['id'];
    use HasFactory;

    protected $with = ['alamatTerpasang'];

    public function spliter():BelongsTo
    {
        return $this->belongsTo(Spliters::class, 'spliter_id', 'id');
    }

    public function paketLayanan():HasOne
    {
        return $this->hasOne(Pakets::class, 'id', 'service_packages_id');
    }

    public function alamatTerpasang(): HasOne
    {
        return $this->hasOne(CustomersAlamatTerpasang::class, 'pppoe_secret', 'pppoe_secret');
    }
}
