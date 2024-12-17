<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use Faker\Generator as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for($i=0; $i<30; $i++){
            $customer = new Customer();
            $customer->name = $faker->firstName();
            $customer->surname = $faker->lastName();
            $customer->email = $faker->safeEmail();
            $customer->phone = $faker->phoneNumber();
            $customer->address = $faker->streetAddress();

            $customer->save();
        }
    }
}
