<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\VesselPosition;
use Illuminate\Support\Facades\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VesselPosition>
 */
class VesselPositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
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


}
