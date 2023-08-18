<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomersAlamatMaps extends Model
{
    protected $connection   = 'db_customers';
    protected $table        = 'customers_alamat_maps';
    protected $guarded      = ['id'];
    use HasFactory;
}
