<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLampiranpph22sTable extends Migration
{
    
    public function up()
    {
        Schema::create('lampiranpph22s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_user')->unsigned();
            $table->bigInteger('id_pph22')->unsigned();
            $table->text('nama_lampiran')->nullable();
            $table->string('lembar_importir')->nullable();
            $table->string('lembar_pemungut')->nullable();
            $table->timestamps();

            $table->foreign('id_pph22')
                ->references('id')
                ->on('pph22s')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

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
        Schema::dropIfExists('lampiranpph22s');
    }
}
