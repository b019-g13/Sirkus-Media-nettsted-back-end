<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            // Create roles
        $user = Role::create(['name' => 'user']);
        $moderator = Role::create(['name' => 'moderator']);
        $admin = Role::create(['name' => 'admin']);
        $superadmin = Role::create(['name' => 'superadmin']);

    }
}
