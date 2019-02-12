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
            $table->uuid('id')->primary();
            $table->uuid('component_id')->nullable();
            $table->foreign('component_id')->references('id')->on('components');
            $table->uuid('field_id')->nullable();
            $table->foreign('field_id')->references('id')->on('fields');
            $table->longText('value');
            $table->uuid('link_id')->nullable();
            $table->foreign('link_id')->references('id')->on('links');
            $table->uuid('image_id')->nullable();
            $table->foreign('image_id')->references('id')->on('images');
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
