<?php

use Illuminate\Database\Seeder;

use App\FieldType;
use Carbon\Carbon;

class FieldTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FieldType::create(['name' => 'Tekst', 'slug' => 'string']);
        FieldType::create(['name' => 'Tekstområde', 'slug' => 'text']);
        FieldType::create(['name' => 'Farge (hexkode)', 'slug' => 'hex_color']);
        FieldType::create(['name' => 'Ikon', 'slug' => 'icon']);
        FieldType::create(['name' => 'Bilde', 'slug' => 'image']);
        FieldType::create(['name' => 'Intern link', 'slug' => 'url_internal']);
        FieldType::create(['name' => 'Ekstern link', 'slug' => 'url_external']);
    }
}
