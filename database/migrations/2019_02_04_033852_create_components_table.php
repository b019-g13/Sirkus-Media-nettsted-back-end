<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table)
        {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug');
            $table->uuid('parent_id')->nullable();
            $table->timestamps();
        });
        Schema::table('components', function(Blueprint $table){
            $table->foreign('parent_id')->references('id')->on('components')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('components');
    }
}
