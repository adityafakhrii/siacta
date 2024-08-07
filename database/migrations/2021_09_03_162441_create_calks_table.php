<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_user')->unsigned();
            $table->text('umum');
            $table->text('pernyataan_kepatuhan');
            $table->text('dasar_penyusunan');
            $table->text('akum_penyusutan');
            $table->text('pendapatan_beban');
            $table->text('piutang_usaha');
            $table->text('piutang_desa');
            $table->text('piutang_lainnya');
            $table->text('rk_pusat');
            $table->text('aset_tetap_penyelesaian');
            $table->timestamps();

            $table->foreign('id_user')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('calks');
    }
}
