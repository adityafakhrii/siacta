<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalpenyesuaiansTable extends Migration
{
   
    public function up()
    {
        Schema::create('jurnalpenyesuaians', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_transbaru')->unsigned();
            $table->bigInteger('id_akun')->unsigned();
            $table->text('tgl');
            $table->text('keterangan');
            $table->integer('debit')->nullable();
            $table->integer('kredit')->nullable();
            $table->timestamps();

            $table->foreign('id_transbaru')
                ->references('id')
                ->on('transbarus')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('id_akun')
                ->references('id')
                ->on('akuns')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jurnalpenyesuaians');
    }
}
