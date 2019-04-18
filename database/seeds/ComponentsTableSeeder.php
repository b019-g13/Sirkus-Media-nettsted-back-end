<?php

use App\Component;
use App\ComponentField;
use App\Field;
use App\FieldType;
use Illuminate\Database\Seeder;

class ComponentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $field_type_string = FieldType::where('slug', 'string')->first();
        $field_type_text = FieldType::where('slug', 'text')->first();
        $field_type_hex_color = FieldType::where('slug', 'hex_color')->first();
        $field_type_icon = FieldType::where('slug', 'icon')->first();
        $field_type_image = FieldType::where('slug', 'image')->first();
        $field_type_url_internal = FieldType::where('slug', 'url_internal')->first();
        $field_type_url_external = FieldType::where('slug', 'url_external')->first();

        $field_h1 = Field::create([
            'name' => 'Heading 1',
            'slug' => 'h1',
            'field_type_id' => $field_type_string->id,
        ]);

        $field_p = Field::create([
            'name' => 'Paragraph',
            'slug' => 'p',
            'field_type_id' => $field_type_text->id,
        ]);

        $field_img = Field::create([
            'name' => 'Image',
            'slug' => 'img',
            'field_type_id' => $field_type_image->id,
        ]);

        $header_component = Component::create([
            'name' => 'header',
            'slug' => 'header',
        ]);

        ComponentField::create([
            'component_id' => $header_component->id,
            'field_id' => $field_h1->id,
            'nickname' => 'Overskrift',
            'order' => 0,
        ]);

        ComponentField::create([
            'component_id' => $header_component->id,
            'field_id' => $field_p->id,
            'nickname' => 'Tekstområde',
            'order' => 1,
        ]);

        ComponentField::create([
            'component_id' => $header_component->id,
            'field_id' => $field_img->id,
            'nickname' => 'Header bilde',
            'order' => 3,
        ]);
    }
}
