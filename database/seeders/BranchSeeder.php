<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::create([
            'state_id' => 1,
            'name' => 'Philip',
            'branch_code' => '1234',
            'address' => 'Philippines',
            'phone' => '1234567890',
            'status' => 1,
            'created_by' => 1,
        ]);
    }
}
