<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMutasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mutasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id');
            $table->string('tujuan')->nullable();
            $table->string('alasan')->nullable();
            $table->string('tanggal_pindah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mutasi');
    }
}
