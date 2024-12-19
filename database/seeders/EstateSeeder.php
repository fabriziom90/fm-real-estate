<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estate;
use Faker\Generator as Faker;

class EstateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for($i=0; $i<20; $i++){
            $estate = new Estate();
            $estate->name = $faker->word(3, true);
            $estate->description = $faker->paragraphs(1, true);
            $estate->address = $faker->address();
            $estate->city = $faker->state();
            $estate->type = $faker->randomElement(['Appartamento', 'Villa', 'Villino a schiera', 'Loft']);
            $estate->sale_type = $faker->randomElement([1,2]); //1 - Sell, 2 - Rent
            $estate->mq = $faker->numberBetween(50, 350);
            $estate->price = $faker->randomNumber(6, true);
            $estate->number_bathrooms = $faker->randomElement([1,2,3]);
            $estate->number_rooms = $faker->randomElement([2,4,6]);
            $estate->elevator = $faker->boolean();
            $estate->garden = $faker->boolean();
            $estate->parking_space = $faker->boolean();
            $estate->balcony = $faker->boolean();
            $estate->energetic_efficency = $faker->randomElement(['A+++', 'A++', 'A+', 'A', 'B', 'C', 'D', 'E']);

            $estate->save();
        }
    }
}
