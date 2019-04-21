<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->uuid('component_id');
            $table->foreign('component_id')->references('id')->on('components')->onDelete('cascade');
            $table->uuid('field_id');
            $table->foreign('field_id')->references('id')->on('fields')->onDelete('cascade');
            $table->string('nickname')->nullable()->default(null);
            $table->integer('order')->default(0);
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
