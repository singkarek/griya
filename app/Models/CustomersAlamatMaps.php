<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomersAlamatMaps extends Model
{
    protected $connection   = 'db_customers';
    protected $table        = 'customers_alamat_maps';
    protected $guarded      = ['id'];
    use HasFactory;

    public function customer(): HasOne
    {
        return $this->hasOne(Customers::class, 'pppoe_secret', 'pppoe_secret');
    }
}
