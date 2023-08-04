<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Placement extends Model
{
    protected $connection   = 'db_coverage';
    protected $table        = 'placements';
    protected $guarded      = ['id'];
    use HasFactory;

    public function area():BelongsTo
    {
        return $this->belongsto(CoverageArea::class, 'area_id', 'id');
    }
}
