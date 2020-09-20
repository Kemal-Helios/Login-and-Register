<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Observer']);   
        Role::create(['name' => 'Delegate']);
        Role::create(['name' => 'Client']); 
        
    
    }
}
