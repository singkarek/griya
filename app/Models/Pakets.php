<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pakets extends Model
{
    protected $connection = 'db_company';
    protected $table = 'service_packages';
    protected $guarded = ['id'];
    use HasFactory;

    public function customers():BelongsTo
    {
        return $this->belongsTo(Customers::class, 'id', 'service_packages_id');
    }
}
