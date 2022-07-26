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
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->date('tanggal');
            $table->text('alamat');
            $table->unsignedInteger('ongkir');
            $table->string('no_resi');
            $table->enum('status', [0, 1, 2, 3, 4]); //0 = Menunggu Konfirmasi 1 = Diproses, 2 = Dikirim, 3 = Selesai, 4 = diBatalkan
            $table->unsignedInteger('total_pembayaran');
            $table->string('nomor_resi')->unique();
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
        Schema::dropIfExists('pemesanans');
    }
};