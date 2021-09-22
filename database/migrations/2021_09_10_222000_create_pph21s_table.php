<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePph21sTable extends Migration
{
    
    public function up()
    {
        Schema::create('pph21s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_user')->unsigned();
            $table->text('form_pajak');
            $table->text('tahun_pajak');
            $table->text('nama_wajib');
            $table->text('npwp');
            $table->text('pekerjaan');
            $table->text('no_telepon');
            $table->enum('sk_suami_istri',['kk','hb','ph','mt'])->nullable();
            $table->text('npwp_suami_istri')->nullable();
            $table->integer('klu')->nullable();
            $table->text('no_faks')->nullable();
            $table->bigInteger('phneto_dn');
            $table->bigInteger('phneto_dn_lain')->nullable();
            $table->bigInteger('phneto_ln')->nullable();
            $table->bigInteger('jml_peng_neto');
            $table->bigInteger('zakat_sumbang')->nullable();
            $table->bigInteger('total_peng_neto');
            $table->bigInteger('peng_tidak_pajak');
            $table->integer('tk')->nullable();
            $table->integer('k')->nullable();
            $table->integer('ki')->nullable();
            $table->bigInteger('peng_pajak');
            $table->bigInteger('pph_terutang');
            $table->bigInteger('pengem_pph24')->nullable();
            $table->bigInteger('jml_pph_terutang');
            $table->bigInteger('pph_dipot_ln')->nullable();
            $table->bigInteger('pph_dibayar')->nullable();
            $table->bigInteger('pph_dipungut')->nullable();
            $table->bigInteger('pph25')->nullable();
            $table->bigInteger('stp_pph25')->nullable();
            $table->bigInteger('jml_kredit_pajak')->nullable();
            $table->bigInteger('pph29')->nullable();
            $table->bigInteger('pph28a')->nullable();
            $table->text('tgl_lunas')->nullable();
            $table->text('permohonan')->nullable();
            $table->bigInteger('angsuran_pph25')->nullable();
            $table->enum('status_ang_pph25',['1/12 x Jumlah Pada Angka 13','Penghitungan Dalam Lampiran Tersendiri']);
            $table->text('lampiran')->nullable();
            $table->enum('pengisi_spt',['Wajib Pajak','Kuasa']);
            $table->text('tgl_pernyataan');
            $table->text('nama_pem_kerja');
            $table->text('npwp_pem_kerja');

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
        Schema::dropIfExists('pph21s');
    }
}