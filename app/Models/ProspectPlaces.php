<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProspectPlaces extends Model
{
    protected $connection   = 'db_oprasional';
    protected $table        = 'prospects_places';
    protected $guarded      = ['id'];
    use HasFactory;

    public function points():HasMany
    {
        return $this->hasMany(ProspectPoints::class, 'place_id');
    }
}
