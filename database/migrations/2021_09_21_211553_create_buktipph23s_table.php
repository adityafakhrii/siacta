<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuktipph23sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buktipph23s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_user')->unsigned();
            $table->text('no_bukti');
            $table->text('npwp')->nullable();
            $table->text('nama');
            $table->text('alamat');
            $table->text('jenis_penghasilan');
            $table->text('jenis_jasa')->nullable();
            $table->bigInteger('jumlah_peng_bruto');
            $table->bigInteger('tarif_lebih')->nullable();
            $table->float('tarif',8,4);
            $table->bigInteger('pph_dipot');
            $table->text('tempat');
            $table->text('tanggal');
            $table->text('npwp_pemotong');
            $table->text('nama_pemotong');
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
        Schema::dropIfExists('buktipph23s');
    }
}
