<?php

namespace Database\Seeders;

use App\Models\Customer;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create();

        for ($i = 0; $i < 10; $i++) {
            Customer::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'status' => $faker->randomElement([0, 1]),
                'created_by' => 1,
            ]);
        }
    }
}
