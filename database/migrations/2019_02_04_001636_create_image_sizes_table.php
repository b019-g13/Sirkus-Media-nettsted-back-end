<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageSizesTable extends Migration
{
   
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::create('image_sizes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('max_width');
            $table->integer('max_height');          
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    
    public function down()
    {
        Schema::dropIfExists('image_sizes');
    }

    
}
