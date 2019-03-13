<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) 
        {
            $table->uuid('id')->primary();
            $table->unsignedInteger('image_size_id');
            $table->foreign('image_size_id')->references('id')->on('image_sizes');
            $table->uuid('user_id');
            $table->string('attribute_alt')->nullable();
            $table->string('url');
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
        Schema::dropIfExists('images');
    }
}
