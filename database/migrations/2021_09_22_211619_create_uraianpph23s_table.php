<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUraianpph23sTable extends Migration
{
    
    public function up()
    {
        Schema::create('uraianpph23s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_user')->unsigned();
            $table->bigInteger('id_pph23')->unsigned();
            $table->text('uraian')->nullable();
            $table->text('npwp_pph23')->nullable();
            $table->text('kap_kjs')->nullable();
            $table->bigInteger('jumlah_peng_bruto')->nullable();
            $table->integer('tl_pph23')->nullable();
            $table->float('t_pph23',8,4)->nullable();
            $table->bigInteger('pph_dipot23')->nullable();
            $table->timestamps();

            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('id_pph23')
                ->references('id')
                ->on('pph23s')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');


        });
    }

    public function down()
    {
        Schema::dropIfExists('uraianpph23s');
    }
}
