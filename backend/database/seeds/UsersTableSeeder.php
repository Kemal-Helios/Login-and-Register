<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        DB::table('role_user')->truncate();
        $adminRole  = Role::where('name', 'admin')->first();

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('secretAdmin'),
            'country_code' => '0090',
            'mobile' => '5510711558',
            'discount_code' => 'admin01',
            'status' => 'Active', 
            'created_at' => date('Y-m-d H:i'),
            'updated_at' => date('Y-m-d H:i')
        ]);
        
        $admin->roles()->attach($adminRole);
    }
}
