<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLampiranpph23sTable extends Migration
{
    public function up()
    {
        Schema::create('lampiranpph23s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_user')->unsigned();
            $table->bigInteger('id_pph23')->unsigned();
            $table->text('nama_lampiran')->nullable();
            $table->integer('lembar_setoran')->nullable();
            $table->integer('lembar_bukti')->nullable();
            $table->timestamps();

            $table->foreign('id_pph23')
                ->references('id')
                ->on('pph23s')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lampiranpph23s');
    }
}
