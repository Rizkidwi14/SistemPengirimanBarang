<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengirimanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id();
            $table->integer('no_stpb')->unique();
            $table->foreignId('driver_id')->references('id')->on('drivers')->onDelete('cascade');
            $table->foreignId('toko_id')->references('id')->on('toko')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('no_polisi', 11);
            $table->string('kategori', 20);
            $table->json('barang')->nullable();
            $table->integer('kotak_peluru');
            $table->integer('status');
            $table->time('waktu_kirim')->nullable();
            $table->time('waktu_terima')->nullable();
            $table->string('penerima', 50)->nullable();
            $table->string('keterangan', 100)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengiriman');
    }
}
