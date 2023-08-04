<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoverageArea extends Model
{
    protected $connection = 'db_coverage';
    protected $table = 'coverage_areas';
    protected $guarded = ['id'];
    use HasFactory;

    public function placements():HasMany
    {
        return $this->hasMany(Placement::class, 'area_id');
    }
}
