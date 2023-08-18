<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomersAlamatTerpasang extends Model
{
    protected $connection   = 'db_customers';
    protected $table        = 'customers_alamat_terpasang';
    protected $guarded      = ['id'];
    use HasFactory;
}
