<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('states')->delete();

        $states = [
            "Abra",
            "Agusan del Norte",
            "Agusan del Sur",
            "Aklan",
            "Albay",
            "Antique",
            "Apayao",
            "Aurora",
            "Basilan",
            "Bataan",
            "Batanes",
            "Batangas",
            "Benguet",
            "Biliran",
            "Bohol",
            "Bukidnon",
            "Bulacan",
            "Cagayan",
            "Camarines Norte",
            "Camarines Sur",
            "Camiguin",
            "Capiz",
            "Catanduanes",
            "Cavite",
            "Cebu",
            "Cotabato",
            "Davao de Oro",
            "Davao del Norte",
            "Davao del Sur",
            "Davao Occidental",
            "Davao Oriental",
            "Dinagat Islands",
            "Eastern Samar",
            "Guimaras",
            "Ifugao",
            "Ilocos Norte",
            "Ilocos Sur",
            "Iloilo",
            "Isabela",
            "Kalinga",
            "La Union",
            "Laguna",
            "Lanao del Norte",
            "Lanao del Sur",
            "Leyte",
            "Maguindanao",
            "Marikina",
            "Marinduque",
            "Masbate",
            "Makati",
            "Malabon",
            "Manila",
            "Mandaluyong",
            "Muntinlupa",
            "Navotas",
            "Northern Samar",
            "Nueva Ecija",
            "Nueva Vizcaya",
            "Occidental Mindoro",
            "Oriental Mindoro",
            "Palawan",
            "Pampanga",
            "Pangasinan",
            "Parañaque",
            "Pasay",
            "Pasig",
            "Pateros",
            "Quezon",
            "Quirino",
            "Rizal",
            "Romblon",
            "San Juan",
            "Samar",
            "Sarangani",
            "Siquijor",
            "Sorsogon",
            "South Cotabato",
            "Southern Leyte",
            "Sultan Kudarat",
            "Sulu",
            "Surigao del Norte",
            "Surigao del Sur",
            "Taguig",
            "Tarlac",
            "Tawi-Tawi",
            "Valenzuela",
            "Zambales",
            "Zamboanga del Norte",
            "Zamboanga del Sur",
            "Zamboanga Sibugay",
        ];

        $data = [];
        foreach ($states as $key => $state) {
            $data[] = [
                'id' => $key+1,
                'country_id' => 141,
                'name' => $state,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('states')->insert($data);

        $states = [
            "Abu Dhabi",
            "Dubai",
            "Sharjah",
            "Umm Al Qaiwain",
            "Fujairah",
            "Ajman",
            "Ras Al Khaimah",
        ];

        ++$key;

        $data = [];
        foreach ($states as $state) {
            $data[] = [
                'id' => ++$key,
                'country_id' => 186,
                'name' => $state,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('states')->insert($data);
    }
}
