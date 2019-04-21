<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedInteger('image_size_id');
            $table->foreign('image_size_id')->references('id')->on('image_sizes');
            $table->uuid('user_id');
            $table->string('attribute_alt')->nullable();
            $table->string('url');
            $table->tinyInteger('privacy')->unsigned()->default(0); // 0 = Private, 1 = Public
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
