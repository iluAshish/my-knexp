<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DateLockWeekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $holidays = [
            ['week_days' => '0'],
            ['week_days' => '5'],
            // Add more holiday dates as needed
        ];

        DB::table('date_lock_weeks')->insert($holidays);
    }
}
