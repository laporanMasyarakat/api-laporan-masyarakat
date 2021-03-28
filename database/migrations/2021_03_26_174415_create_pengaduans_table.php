<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengaduansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->integer('id_pengaduan');
            $table->date('tgl_pengaduan');
            $table->char('nik',16);
            $table->text('isi_laporan');
            $table->string('kota');
            $table->string('longtitude');
            $table->string('latitude');
            $table->string('foto');
            $table->enum('status', ['proses','selesai']);
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
        Schema::dropIfExists('pengaduan');
    }
}
