<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePph21sTable extends Migration
{
    
    public function up()
    {
        Schema::create('pph21s', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user')->unsigned();
            $table->text('form_pajak');
            $table->text('tahun_pajak');
            $table->text('nama_wajib');
            $table->integer('npwp');
            $table->text('pekerjaan');
            $table->text('no_telepon');
            $table->enum('sk_suami_istri',['kk','hb','ph','mt'])->nullable();
            $table->integer('npwp_suami_istri')->nullable();
            $table->integer('klu')->nullable();
            $table->text('no_faks')->nullable();
            $table->integer('phneto_dn');
            $table->integer('phneto_dn_lain')->nullable();
            $table->integer('phneto_ln')->nullable();
            $table->integer('jml_peng_neto');
            $table->integer('zakat_sumbang')->nullable();
            $table->integer('total_peng_neto');
            $table->integer('peng_tidak_pajak');
            $table->enum('status_kawin',['tk','k','k1']);
            $table->integer('peng_pajak');
            $table->integer('pph_terutang');
            $table->integer('pengem_pph24')->nullable();
            $table->integer('jml_pph_terutang');
            $table->integer('pph_dipot_ln')->nullable();
            $table->integer('pph_dibayar')->nullable();
            $table->integer('pph_dipungut')->nullable();
            $table->integer('pph25')->nullable();
            $table->integer('stp_pph25')->nullable();
            $table->integer('jml_kredit_pajak')->nullable();
            $table->integer('pph29')->nullable();
            $table->integer('pph28a')->nullable();
            $table->integer('tgl_lunas')->nullable();
            $table->enum('permohonan',['Direstitusikan','Diperhitungkan dengan Utang Pajak','Dikembalikan dengan SKPPKP Pasal 17C (WP dengan Kriteria Tertentu)','Dikembalikan dengan SKPPKP Pasal 17D (WP yang Memenuhi Persyaratan Tertentu)']);
            $table->integer('angsuran_pph25')->nullable();
            $table->enum('status_ang_pph25',['1/12 x Jumlah Pada Angka 13','Penghitungan Dalam Lampiran Tersendiri']);
            $table->text('lampiran')->nullable();
            $table->enum('pengisi_spt',['Wajib Pajak','Kuasa']);
            $table->text('tgl_pernyataan');
            $table->text('nama_pem_kerja');
            $table->integer('npwp_pem_kerja');

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