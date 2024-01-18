<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleTripDistance extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }
}
