<?php

use App\ImageSize;
use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ImageSize::create(['name' => 'large', 'max_width' => 1920, 'max_height' => 1080]);
        ImageSize::create(['name' => 'medium', 'max_width' => 1366, 'max_height' => 768]);
        ImageSize::create(['name' => 'small', 'max_width' => 960, 'max_height' => 540]);
        ImageSize::create(['name' => 'thumbnail', 'max_width' => 480, 'max_height' => 480]);
    }
}
