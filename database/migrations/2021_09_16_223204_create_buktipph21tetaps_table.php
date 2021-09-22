<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuktipph21tetapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buktipph21tetaps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_user')->unsigned();
            $table->string('no_form');
            $table->text('nomor');
            $table->text('npwp_pemotong');
            $table->text('nama_pemotong');
            $table->text('npwp')->nullable();
            $table->text('nik_paspor');
            $table->text('nama');
            $table->text('alamat');
            $table->enum('jenis_kelamin',['Laki-laki','Perempuan']);
            $table->integer('k')->nullable();
            $table->integer('tk')->nullable();
            $table->integer('hb')->nullable();
            $table->text('jabatan');
            $table->enum('kar_asing',['Ya','Tidak']);
            $table->text('kode_negara')->nullable();
            $table->text('kode_objek');
            $table->bigInteger('gaji_pensiun');
            $table->bigInteger('tunjangan_pph')->nullable();
            $table->bigInteger('tunjangan_lain')->nullable();
            $table->bigInteger('honorarium')->nullable();
            $table->bigInteger('premi_asuransi')->nullable();
            $table->bigInteger('natura')->nullable();
            $table->bigInteger('tantiem')->nullable();
            $table->bigInteger('jumlah_peng_bruto');
            $table->bigInteger('biaya_jabatan')->nullable();
            $table->bigInteger('iuran_pensiun')->nullable();
            $table->bigInteger('jumlah_pengurangan');
            $table->bigInteger('jumlah_peng_neto');
            $table->bigInteger('ptkp');
            $table->bigInteger('pkp');
            $table->float('persen_pajak');
            $table->bigInteger('pph21_pkp');
            $table->bigInteger('pph21_dipotong');
            $table->bigInteger('pph21_terutang');
            $table->bigInteger('pph21_pph26');
            $table->text('npwp_id_pemotong');
            $table->text('nama_id_pemotong');
            $table->text('tgl_pemotong');

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
        Schema::dropIfExists('buktipph21tetaps');
    }


}
