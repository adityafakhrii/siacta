<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePph22sTable extends Migration
{
    
    public function up()
    {
        Schema::create('pph22s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_user')->unsigned();
            $table->text('masa_pajak');
            $table->text('npwp');
            $table->text('nama');
            $table->text('alamat');

            $table->text('kap_badan_usaha')->nullable();
            $table->bigInteger('nop_badan_usaha')->nullable();
            $table->bigInteger('pph_badan_usaha')->nullable();
            $table->text('npwp_badan_usaha')->nullable();
            $table->integer('tl_badan_usaha')->nullable();
            $table->float('t_badan_usaha',8,4)->nullable();

            $table->text('kap_penj_barang')->nullable();
            $table->bigInteger('nop_penj_barang')->nullable();
            $table->bigInteger('pph_penj_barang')->nullable();
            $table->text('npwp_penj_barang')->nullable();
            $table->integer('tl_penj_barang')->nullable();
            $table->float('t_penj_barang',8,4)->nullable();

            $table->text('kap_pembelian_bend')->nullable();
            $table->bigInteger('nop_pembelian_bend')->nullable();
            $table->bigInteger('pph_pembelian_bend')->nullable();
            $table->text('npwp_pembelian_bend')->nullable();
            $table->integer('tl_pembelian_bend')->nullable();
            $table->float('t_pembelian_bend',8,4)->nullable();

            $table->text('kap_api')->nullable();
            $table->bigInteger('nop_api')->nullable();
            $table->bigInteger('pph_api')->nullable();
            $table->text('npwp_api')->nullable();
            $table->integer('tl_api')->nullable();
            $table->float('t_api',8,4)->nullable();

            $table->text('kap_non_api')->nullable();
            $table->bigInteger('nop_non_api')->nullable();
            $table->bigInteger('pph_non_api')->nullable();
            $table->text('npwp_non_api')->nullable();
            $table->integer('tl_non_api')->nullable();
            $table->float('t_non_api',8,4)->nullable();

            $table->text('kap_hasil_lelang')->nullable();
            $table->bigInteger('nop_hasil_lelang')->nullable();
            $table->bigInteger('pph_hasil_lelang')->nullable();
            $table->text('npwp_hasil_lelang')->nullable();
            $table->integer('tl_hasil_lelang')->nullable();
            $table->float('t_hasil_lelang',8,4)->nullable();

            $table->text('kap_spbu')->nullable();
            $table->bigInteger('nop_spbu')->nullable();
            $table->bigInteger('pph_spbu')->nullable();
            $table->text('npwp_spbu')->nullable();
            $table->integer('tl_spbu')->nullable();
            $table->float('t_spbu',8,4)->nullable();

            $table->text('kap_pihak_lain')->nullable();
            $table->bigInteger('nop_pihak_lain')->nullable();
            $table->bigInteger('pph_pihak_lain')->nullable();
            $table->text('npwp_pihak_lain')->nullable();
            $table->integer('tl_pihak_lain')->nullable();
            $table->float('t_pihak_lain',8,4)->nullable();

            $table->text('kap_bumn')->nullable();
            $table->bigInteger('nop_bumn')->nullable();
            $table->bigInteger('pph_bumn')->nullable();
            $table->text('npwp_bumn')->nullable();
            $table->integer('tl_bumn')->nullable();
            $table->float('t_bumn',8,4)->nullable();

            $table->text('kap_penj_hasil')->nullable();
            $table->bigInteger('nop_penj_hasil')->nullable();
            $table->bigInteger('pph_penj_hasil')->nullable();
            $table->text('npwp_penj_hasil')->nullable();
            $table->integer('tl_penj_hasil')->nullable();
            $table->float('t_penj_hasil',8,4)->nullable();

            $table->text('kap_penj_ken')->nullable();
            $table->bigInteger('nop_penj_ken')->nullable();
            $table->bigInteger('pph_penj_ken')->nullable();
            $table->text('npwp_penj_ken')->nullable();
            $table->integer('tl_penj_ken')->nullable();
            $table->float('t_penj_ken',8,4)->nullable();

            $table->text('kap_pemb_batu')->nullable();
            $table->bigInteger('nop_pemb_batu')->nullable();
            $table->bigInteger('pph_pemb_batu')->nullable();
            $table->text('npwp_pemb_batu')->nullable();
            $table->integer('tl_pemb_batu')->nullable();
            $table->float('t_pemb_batu',8,4)->nullable();

            $table->text('kap_penj_emas')->nullable();
            $table->bigInteger('nop_penj_emas')->nullable();
            $table->bigInteger('pph_penj_emas')->nullable();
            $table->text('npwp_penj_emas')->nullable();
            $table->integer('tl_penj_emas')->nullable();
            $table->float('t_penj_emas',8,4)->nullable();

            $table->text('jumlah_nop');
            $table->text('jumlah_pph');

            $table->enum('pengisi_spt',['Pemungut Pajak/Pimpinan','Kuasa Wajib Pajak']);
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
        Schema::dropIfExists('pph22s');
    }
}
