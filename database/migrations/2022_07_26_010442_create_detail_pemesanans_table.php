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
        Schema::create('detail_pemesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained();
            $table->foreignId('pemesanan_id')->constrained();
            $table->unsignedInteger('qty');
            $table->enum('status', [0, 1, 2, 3, 4, 5]); // 0 = Menunggu Konfirmasi, 1 = DiProses, 2 = Dikirim, 3 = Selesai , 4 = Ulasan, 5 Gagal;
            $table->string('keterangan')->nullable();
            $table->string('no_resi')->nullable();
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
        Schema::dropIfExists('detail_pemesanans');
    }
};