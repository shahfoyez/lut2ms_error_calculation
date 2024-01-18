<?php

namespace App\Models;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fuel extends Model
{
    use HasFactory;
    protected $guarded = [];
    // protected $with = ['employee'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vid');
    }
    // Attribute Casting for automatically be cast to Carbon instances
    protected $dates = [
        'date'
    ];
}
