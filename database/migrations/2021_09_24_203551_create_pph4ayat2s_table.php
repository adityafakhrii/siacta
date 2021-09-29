<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePph4ayat2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pph4ayat2s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_user')->unsigned();
            $table->text('tahun_pajak');
            $table->text('npwp');
            $table->text('nama');
            $table->text('periode1');
            $table->text('periode2');

            $table->bigInteger('dpp_deposito')->nullable();
            $table->float('tarif_deposito',8,4)->nullable();
            $table->bigInteger('pph_deposito')->nullable();

            $table->bigInteger('dpp_diskonto')->nullable();
            $table->float('tarif_diskonto',8,4)->nullable();
            $table->bigInteger('pph_diskonto')->nullable();

            $table->bigInteger('dpp_bursaefek')->nullable();
            $table->float('tarif_bursaefek',8,4)->nullable();
            $table->bigInteger('pph_bursaefek')->nullable();

            $table->bigInteger('dpp_ventura')->nullable();
            $table->float('tarif_ventura',8,4)->nullable();
            $table->bigInteger('pph_ventura')->nullable();

            $table->bigInteger('dpp_bbm')->nullable();
            $table->float('tarif_bbm',8,4)->nullable();
            $table->bigInteger('pph_bbm')->nullable();

            $table->bigInteger('dpp_haktanah')->nullable();
            $table->float('tarif_haktanah',8,4)->nullable();
            $table->bigInteger('pph_haktanah')->nullable();

            $table->bigInteger('dpp_sewa')->nullable();
            $table->float('tarif_sewa',8,4)->nullable();
            $table->bigInteger('pph_sewa')->nullable();

            $table->bigInteger('dpp_pelkonstruksi')->nullable();
            $table->float('tarif_pelkonstruksi',8,4)->nullable();
            $table->bigInteger('pph_pelkonstruksi')->nullable();

            $table->bigInteger('dpp_perenkonstruksi')->nullable();
            $table->float('tarif_perenkonstruksi',8,4)->nullable();
            $table->bigInteger('pph_perenkonstruksi')->nullable();

            $table->bigInteger('dpp_pengkonstruksi')->nullable();
            $table->float('tarif_pengkonstruksi',8,4)->nullable();
            $table->bigInteger('pph_pengkonstruksi')->nullable();

            $table->bigInteger('dpp_dagang')->nullable();
            $table->float('tarif_dagang',8,4)->nullable();
            $table->bigInteger('pph_dagang')->nullable();

            $table->bigInteger('dpp_penerbangan')->nullable();
            $table->float('tarif_penerbangan',8,4)->nullable();
            $table->bigInteger('pph_penerbangan')->nullable();

            $table->bigInteger('dpp_pelayaran')->nullable();
            $table->float('tarif_pelayaran',8,4)->nullable();
            $table->bigInteger('pph_pelayaran')->nullable();

            $table->bigInteger('dpp_aktiva')->nullable();
            $table->float('tarif_aktiva',8,4)->nullable();
            $table->bigInteger('pph_aktiva')->nullable();

            $table->bigInteger('dpp_derivatif')->nullable();
            $table->float('tarif_derivatif',8,4)->nullable();
            $table->bigInteger('pph_derivatif')->nullable();

            $table->bigInteger('dpp_peredaran')->nullable();
            $table->float('tarif_peredaran',8,4)->nullable();
            $table->bigInteger('pph_peredaran')->nullable();

            $table->text('jumlah_jba');

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
        Schema::dropIfExists('pph4ayat2s');
    }
}
