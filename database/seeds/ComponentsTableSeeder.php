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
        // Get all field types
        $field_type_string = FieldType::where('slug', 'string')->first();
        $field_type_text = FieldType::where('slug', 'text')->first();
        $field_type_hex_color = FieldType::where('slug', 'hex_color')->first();
        $field_type_icon = FieldType::where('slug', 'icon')->first();
        $field_type_image = FieldType::where('slug', 'image')->first();
        $field_type_url_internal = FieldType::where('slug', 'url_internal')->first();
        $field_type_url_external = FieldType::where('slug', 'url_external')->first();

        // Create all fields --- start
        $field_h1 = Field::create([
            'name' => 'Overskrift 1',
            'slug' => 'h1',
            'field_type_id' => $field_type_string->id,
        ]);

        $field_h2 = Field::create([
            'name' => 'Overskrift 2',
            'slug' => 'h2',
            'field_type_id' => $field_type_string->id,
        ]);

        $field_h3 = Field::create([
            'name' => 'Overskrift 3',
            'slug' => 'h3',
            'field_type_id' => $field_type_string->id,
        ]);

        $field_p = Field::create([
            'name' => 'Paragraf',
            'slug' => 'p',
            'field_type_id' => $field_type_text->id,
        ]);

        $field_a_int = Field::create([
            'name' => 'Link (intern)',
            'slug' => 'a_int',
            'field_type_id' => $field_type_url_internal->id,
        ]);

        $field_a_ext = Field::create([
            'name' => 'Link (ekstern)',
            'slug' => 'a_ext',
            'field_type_id' => $field_type_url_external->id,
        ]);

        $field_img = Field::create([
            'name' => 'Bilde',
            'slug' => 'img',
            'field_type_id' => $field_type_image->id,
        ]);
        // Create all fields --- end

        // Define component: icon text --- start
        $icon_text_component = Component::create([
            'name' => 'Ikon m. tekst',
            'slug' => 'icon-text',
        ]);

        ComponentField::create([
            'component_id' => $icon_text_component->id,
            'field_id' => $field_img->id,
            'nickname' => 'Ikon',
            'order' => 0,
        ]);

        ComponentField::create([
            'component_id' => $icon_text_component->id,
            'field_id' => $field_p->id,
            'nickname' => 'Tekst',
            'order' => 1,
        ]);
        // Define component: icon text --- end

        // Define component: Header --- start
        $header_component = Component::create([
            'name' => 'Header',
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
            'nickname' => 'Tekstområde 1',
            'order' => 1,
        ]);

        ComponentField::create([
            'component_id' => $header_component->id,
            'field_id' => $field_p->id,
            'nickname' => 'Tekstområde 2',
            'order' => 2,
        ]);

        ComponentField::create([
            'component_id' => $header_component->id,
            'field_id' => $field_p->id,
            'nickname' => 'Tekstområde 3',
            'order' => 3,
        ]);

        ComponentField::create([
            'component_id' => $header_component->id,
            'field_id' => $field_a_ext->id,
            'nickname' => 'Link 1',
            'order' => 4,
        ]);

        ComponentField::create([
            'component_id' => $header_component->id,
            'field_id' => $field_a_ext->id,
            'nickname' => 'Link 2',
            'order' => 5,
        ]);

        ComponentField::create([
            'component_id' => $header_component->id,
            'field_id' => $field_img->id,
            'nickname' => 'Header bilde',
            'order' => 6,
        ]);
        // Define component: Header --- end

        // Define component: Action box --- start
        $action_box_component = Component::create([
            'name' => 'Action box',
            'slug' => 'action-box',
            'parent_id' => $header_component->id,
        ]);

        ComponentField::create([
            'component_id' => $action_box_component->id,
            'field_id' => $field_h2->id,
            'nickname' => 'Overskrift',
            'order' => 0,
        ]);
        // Define component: Action box --- end

        // Define component: Action box child --- start
        $action_box_child_component = Component::create([
            'name' => 'Action box barn',
            'slug' => 'action-box-child',
            'parent_id' => $action_box_component->id,
        ]);

        ComponentField::create([
            'component_id' => $action_box_child_component->id,
            'field_id' => $field_h3->id,
            'nickname' => 'Overskrift',
            'order' => 0,
        ]);

        ComponentField::create([
            'component_id' => $action_box_child_component->id,
            'field_id' => $field_p->id,
            'nickname' => 'Tekst',
            'order' => 0,
        ]);
        // Define component: Action box child --- end
    }
}
