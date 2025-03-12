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
        Schema::create('log_antrian_loket', function (Blueprint $table) {
            $table->string('no_rawat')->primary();
            $table->string('kd_loket');
            $table->foreign('kd_loket')->references('kd_loket')->on('loket')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_antrian_loket');
    }
};
