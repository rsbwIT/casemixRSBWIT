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
        Schema::create('loket', function (Blueprint $table) {
            $table->string('kd_loket')->primary();
            $table->string('nama_loket');
            $table->string('kd_pendaftaran');
            $table->foreign('kd_pendaftaran')->references('kd_pendaftaran')->on('pendaftaran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loket');
    }
};
