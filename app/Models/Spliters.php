<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Spliters extends Model
{
    protected $connection   = 'db_coverage';
    protected $table        = 'spliters';
    protected $guarded      = ['id'];
    use HasFactory;

    public function customers():HasMany
    {
        return $this->hasMany(Customers::class, 'spliter_id');
    }
}
