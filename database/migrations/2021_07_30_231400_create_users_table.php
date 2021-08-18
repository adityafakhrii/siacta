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
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role',['superadmin','bumdes','unitusaha']);
            $table->bigInteger('id_unitusaha')->unsigned()->nullable();
            $table->enum('status_neracaawal',['belum_final','final'])->nullable();
            $table->timestamps();

            $table->foreign('id_unitusaha')
                ->references('id')
                ->on('unitusahas')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
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
