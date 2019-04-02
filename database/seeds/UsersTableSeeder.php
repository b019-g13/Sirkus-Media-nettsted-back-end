<?php

use Illuminate\Database\Seeder;

use App\User;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (app()->environment() === 'local') {
            $user = User::create([
                'name' => 'Admin bruker',
                'email' => 'admin@example.com',
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
                'email_verified_at' => Carbon::now()
            ]);
        }
    }
}
