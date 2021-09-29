<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePph23sTable extends Migration
{
    public function up()
    {
        Schema::create('pph23s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_user')->unsigned();
            $table->text('masa_pajak');
            $table->text('npwp');
            $table->text('nama');
            $table->text('alamat');

            $table->text('total_peng_bruto');
            $table->text('total_pph');

            $table->enum('pengisi_spt',['Pemotong Pajak/Pimpinan','Kuasa Wajib Pajak']);
            $table->text('nama_pengisi');
            $table->text('npwp_pengisi');
            $table->text('tanggal');
            $table->timestamps();

            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pph23s');
    }
}
