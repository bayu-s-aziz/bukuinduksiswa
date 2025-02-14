<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiodataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biodata', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->onDelete('cascade');
            $table->string('uri')->unique();
            $table->string('alamat')->nullable();
            $table->string('desa')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kota')->nullable();
            $table->string('propinsi')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('tanggal_lahir')->nullable();
            $table->integer('anak_ke')->nullable();
            $table->integer('jmlh_saudara')->nullable();
            $table->integer('saudara_tiri')->nullable();
            $table->integer('saudara_angkat')->nullable();
            $table->string('status_anak')->nullable();
            $table->string('bahasa')->nullable();
            $table->string('agama')->nullable();
            $table->string('penyakit')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->string('ciri')->nullable();
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
        Schema::dropIfExists('biodata');
    }
}
