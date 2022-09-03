<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VesselPosition;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class VesselPositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(storage_path() . "/app/public/Seeders/ship_positions.json");
        $vesselPositions = json_decode($json);

        foreach ($vesselPositions as $key => $value){
            VesselPosition::query()->updateOrCreate([
                'mmsi' => $value->mmsi,
                'status' => $value->status,
                'station' => $value->stationId,
                'speed' => $value->speed,
                'lon' => $value->lon,
                'lat' => $value->lat,
                'course' => $value->course,
                'heading' => $value->heading,
                'rot' => $value->rot,
                'timestamp' => $value->timestamp
            ]);
        }
    }
}
