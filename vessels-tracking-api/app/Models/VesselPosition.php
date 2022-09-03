<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VesselPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'mmsi',
        'status',
        'station',
        'speed',
        'lon',
        'lat',
        'course',
        'heading',
        'rot',
        'timestamp'
    ];
}
