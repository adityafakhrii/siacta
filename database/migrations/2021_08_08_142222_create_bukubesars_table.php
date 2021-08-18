<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukubesarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bukubesars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_akun')->unsigned();
            $table->integer('debit')->nullable();
            $table->integer('kredit')->nullable();
            $table->integer('saldo');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_akun')
                ->references('id')
                ->on('akuns')
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
        Schema::dropIfExists('bukubesars');
    }
}
