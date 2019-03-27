<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_components', function (Blueprint $table)
        {
            $table->uuid('id')->primary();
            $table->uuid('page_id');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->uuid('component_id');
            $table->foreign('component_id')->references('id')->on('components')->onDelete('cascade');
            $table->uuid('field_id');
            $table->foreign('field_id')->references('id')->on('fields')->onDelete('cascade');
            $table->longText('value')->nullable()->default(null);
            $table->uuid('link_id')->nullable()->default(null);
            $table->foreign('link_id')->references('id')->on('links')->onDelete('set null');
            $table->uuid('image_id')->nullable()->default(null);
            $table->foreign('image_id')->references('id')->on('images')->onDelete('set null');
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
        Schema::dropIfExists('page_components');
    }
}
