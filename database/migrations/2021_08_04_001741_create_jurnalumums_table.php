<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalumumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnalumums', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_transaksi')->unsigned();
            $table->bigInteger('id_akun')->unsigned();
            $table->text('keterangan');
            $table->integer('debit')->nullable();
            $table->integer('kredit')->nullable();
            $table->timestamps();

            $table->foreign('id_transaksi')
                ->references('id')
                ->on('transaksis')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
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
        Schema::dropIfExists('jurnalumums');
    }
}
