<?php

use App\MenuLocation;
use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MenuLocation::create(['name' => 'Topp', 'slug' => 'top']);
        MenuLocation::create(['name' => 'Footer 1', 'slug' => 'footer-1']);
        MenuLocation::create(['name' => 'Footer 2', 'slug' => 'footer-2']);
    }
}
