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
        $areas = ['Z001','Z002','Z003','Z004','Z005','Z006','Z007','Z008','Z009','Z010'];
        foreach($areas as $area){
            $new_area = new Area();
            $new_area->area = $area;

            $new_area->save();
        }
    }
}
