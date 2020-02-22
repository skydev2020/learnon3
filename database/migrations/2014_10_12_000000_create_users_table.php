<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fname');
            $table->string('lname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('ip')->nullable();
            $table->integer('approved')->nullable();
            $table->integer('status')->nullable();
            $table->string('last_login')->nullable();
            $table->rememberToken();
            $table->string('home_phone');
            $table->string('cell_phone');
            $table->string('address');
            $table->string('city');
            $table->bigInteger('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->string('pcode');
            $table->bigInteger('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->bigInteger('grade_id')->references('id')->on('grades')->onDelete('cascade');
            $table->string('subjects');
            $table->string('parent_fname');
            $table->string('parent_lname');
            $table->string('street');
            $table->string('school');
            $table->bigInteger('how_id')->references('id')->on('hows')->onDelete('cascade');
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
        Schema::dropIfExists('users');
    }
}
