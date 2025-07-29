<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('orders')->insert([
                'order_number' => $faker->unique()->uuid,
                'customer_id' => rand(3, 12),
                'shipment_date' => $faker->date,
                'status' => 'Shipment Received',
                'items' => rand(1, 5),
                'origin' => 5,
                'destination' => rand(18, 24),
                'name' => $faker->name,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'created_at' => now(),
                'created_by' => 1,
                'updated_at' => now(),
                'updated_by' => 1,
            ]);
        }
    }
}
