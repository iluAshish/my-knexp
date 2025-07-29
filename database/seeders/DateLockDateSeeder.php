<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DateLockDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $holidays = [
            ['week_dates' => '2023-11-15'],
            ['week_dates' => '2023-12-25'],
            // Add more holiday dates as needed
        ];

        // Insert data into the 'holidays' table
        DB::table('date_lock_dates')->insert($holidays);
    }
}
