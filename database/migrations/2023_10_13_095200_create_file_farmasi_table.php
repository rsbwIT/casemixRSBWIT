<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_farmasi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_rkm_medis', 50);
            $table->string('no_rawat', 50);
            $table->string('nama_pasein', 100);
            $table->string('jenis_berkas', 50);
            $table->string('file', 255)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_farmasi');
    }
};
