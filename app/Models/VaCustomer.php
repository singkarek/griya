<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaCustomer extends Model
{
    protected $connection   = 'db_customers_dasarata';
    protected $table        = 'va_customers';
    protected $guarded      = ['id'];
    protected $timestamps = false;
    use HasFactory;
}
