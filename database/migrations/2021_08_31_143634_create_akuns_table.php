<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkunsTable extends Migration
{

    public function up()
    {
        Schema::create('akuns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_user')->unsigned();
            $table->string('no_akun',9)->unique();
            $table->string('nama_akun');
            $table->enum('saldo_normal',['debit','kredit']);
            $table->enum('status',['penyesuaian','tidak_pen']);
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
        Schema::dropIfExists('akuns');
    }
}
