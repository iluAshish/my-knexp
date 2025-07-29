<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'Super Admin']);
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Branch Manager']);
        Role::firstOrCreate(['name' => 'Delivery Agent']);

        $superAdmin = User::where('email', 'jonathangomez@knexpress.ae')->first();
        $superAdmin2 = User::where('email', 'cedrickgomez@knexpress.ae')->first();
        $superAdmin3 = User::where('email', 'projects.pentacodes@gmail.com')->first();

        if (!$superAdmin) {
            $superAdmin = User::create([
                'first_name' => 'Jonathan',
                'last_name' => 'Gomez',
                'email' => 'jonathangomez@knexpress.ae',
                'phone' => '0585793070',
                'password' => bcrypt('JonatHAN@goMEz23'),
                'status' => 1,
                'email_verified_at' => now(),
            ]);
        }
        if (!$superAdmin2) {
            $superAdmin2 = User::create([
                'first_name' => 'Cedrick',
                'last_name' => 'Gomez',
                'email' => 'cedrickgomez@knexpress.ae',
                'phone' => '0524500801',
                'password' => bcrypt('CedrICk@gOMeZ23'),
                'status' => 1,
                'email_verified_at' => now(),
            ]);
        }
        if (!$superAdmin3) {
            $superAdmin3 = User::create([
                'first_name' => 'Pentacodes',
                'last_name' => 'DXB',
                'email' => 'projects.pentacodes@gmail.com',
                'phone' => '0545864309',
                'password' => bcrypt('Penta@dmin23'),
                'status' => 1,
                'email_verified_at' => now(),
            ]);
        }

        $permissions = Permission::all();

        $data = [];
        DB::table('permission_user')->delete();
        foreach ($permissions as $permission) {
            $data[] = [
                "user_id" => $superAdmin->id,
                "permission_id" => $permission->id
            ];
        }
        foreach ($permissions as $permission) {
            $data[] = [
                "user_id" => $superAdmin2->id,
                "permission_id" => $permission->id
            ];
        }
        foreach ($permissions as $permission) {
            $data[] = [
                "user_id" => $superAdmin3->id,
                "permission_id" => $permission->id
            ];
        }

        DB::table('permission_user')->insert($data);



    }
}
