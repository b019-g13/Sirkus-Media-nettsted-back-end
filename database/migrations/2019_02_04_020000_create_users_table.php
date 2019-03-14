<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table)
        {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->datetime('email_verified_at')->nullable()->default(null);
            $table->string('password');
            $table->string('email_token')->nullable();
            $table->uuid('image_id')->nullable();
            $table->foreign('image_id')->references('id')->on('images')->onUpdate('cascade');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('images', function (Blueprint $table)
        {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
