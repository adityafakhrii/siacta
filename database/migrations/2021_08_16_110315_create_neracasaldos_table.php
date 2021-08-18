<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNeracasaldosTable extends Migration
{
    public function up()
    {
        Schema::create('neracasaldos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_akun')->unsigned();
            $table->bigInteger('id_bukubesar')->unsigned()->nullable();
            $table->integer('debit')->nullable();
            $table->integer('kredit')->nullable();
            $table->timestamps();

            $table->foreign('id_akun')
                ->references('id')
                ->on('akuns')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->foreign('id_bukubesar')
                ->references('id')
                ->on('bukubesars')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('neracasaldos');
    }
}
