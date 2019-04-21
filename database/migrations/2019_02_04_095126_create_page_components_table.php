<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_components', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('order')->default(0);
            $table->uuid('page_id');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->uuid('component_id');
            $table->foreign('component_id')->references('id')->on('components')->onDelete('cascade');
            $table->uuid('component_field_id')->nullable()->default(null);
            $table->foreign('component_field_id')->references('id')->on('component_fields')->onDelete('cascade');
            $table->longText('value')->nullable()->default(null);
            $table->uuid('link_id')->nullable()->default(null);
            $table->foreign('link_id')->references('id')->on('links')->onDelete('set null');
            $table->uuid('image_id')->nullable()->default(null);
            $table->foreign('image_id')->references('id')->on('images')->onDelete('set null');
        });

        Schema::table('page_components', function (Blueprint $table) {
            $table->uuid('parent_id')->nullable()->default(null);
            $table->foreign('parent_id')->references('id')->on('page_components')->onDelete('cascade');
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
