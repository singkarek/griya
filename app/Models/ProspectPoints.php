<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProspectPoints extends Model
{
    protected $connection   = 'db_oprasional';
    protected $table        = 'prospects_points';
    protected $guarded      = ['id'];
    use HasFactory;

    public function placesPoints():BelongsTo
    {
        return $this->belongsTo(ProspectPlaces::class, 'place_id', 'id');
    }

}
