<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component_fields', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('component_id');
            $table->uuid('field_id');
            $table->longText('value');
            $table->uuid('link_id');
            $table->uuid('image_id');
            $table->integer('order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('component_fields');
    }
}
