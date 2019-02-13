<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) 
        {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->boolean('global'); 
            $table->uuid('page_id');
            $table->foreign('page_id')->references('id')->on('pages')->onupdate('cascade');
            $table->integer('menu_location_id')->unsigned();
            $table->foreign('menu_location_id')->references('id')->on('menu_locations')->onupdate('cascade');
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
        Schema::dropIfExists('menus');
    }
}
