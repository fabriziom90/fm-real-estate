<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = ['Z012','Z013','Z014','Z015','Z016','Z017','Z018','Z019','Z020','Z021'];
        foreach($areas as $area){
            $new_area = new Area();
            $new_area->area = $area;

            $new_area->save();
        }
    }
}
