<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNeracasaldoawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('neracasaldoawals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_akun')->unsigned();
            $table->integer('debit')->nullable();
            $table->integer('kredit')->nullable();
            $table->enum('status',['belum_final','final'])->nullable();
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
        Schema::dropIfExists('neracasaldoawals');
    }
}
