<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalpenutupsTable extends Migration
{
    
    public function up()
    {
        Schema::create('jurnalpenutups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_bubespen')->unsigned();
            $table->bigInteger('id_akun')->unsigned();
            $table->bigInteger('id_user')->unsigned();
            $table->text('tgl');
            $table->text('keterangan');
            $table->integer('debit')->nullable();
            $table->integer('kredit')->nullable();
            $table->timestamps();

            $table->foreign('id_bubespen')
                ->references('id')
                ->on('bukubesarpenyesuaians')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('id_akun')
                ->references('id')
                ->on('akuns')
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
        Schema::dropIfExists('jurnalpenutups');
    }
}
