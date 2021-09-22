<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuktipph21tidaktetapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buktipph21tidaktetaps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_user')->unsigned();
            $table->text('no_form');
            $table->text('nomor');
            $table->text('npwp')->nullable();
            $table->text('nik_paspor');
            $table->text('nama');
            $table->text('alamat');
            $table->enum('wajib_ln',['Ya','Tidak']);
            $table->text('kode_negara')->nullable();
            $table->text('kode_objek');
            $table->bigInteger('jumlah_peng_bruto');
            $table->bigInteger('dasar_pajak');
            $table->integer('tarif_lebih');
            $table->integer('tarif');
            $table->bigInteger('pph_dipotong');
            $table->text('npwp_pemotong');
            $table->text('nama_pemotong');
            $table->text('tgl_potong');
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
        Schema::dropIfExists('buktipph21tidaktetaps');
    }
}
