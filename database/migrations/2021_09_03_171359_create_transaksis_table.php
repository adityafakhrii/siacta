<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{

    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_akun')->unsigned();
            $table->bigInteger('id_user')->unsigned();
            $table->text('dok_bukti');
            $table->enum('jenis_pembayaran',['tunai','kredit','dp'])->nullable();
            $table->text('keterangan');
            $table->text('tgl');
            $table->integer('nominal');
            $table->integer('nominal_dp')->nullable();
            $table->integer('nominal_ppn')->nullable();
            $table->integer('nominal_pph22')->nullable();
            $table->integer('nominal_pph23')->nullable();
            $table->integer('potongan_pembelian')->nullable();
            $table->integer('potongan_penjualan')->nullable();
            $table->string('umur_ekonomis')->nullable();
            $table->integer('nilai_sisa')->nullable();
            $table->integer('beban_penyusutan')->nullable();
            $table->enum('status',['pembelian','penjualan','penerimaan_kas','pengeluaran_kas','retur_penjualan','retur_pembelian']);
            $table->timestamps();

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
        Schema::dropIfExists('transaksis');
    }
}
