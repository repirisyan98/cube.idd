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
            $table->string('invoice')->unique();
            $table->foreignId('user_id')->constrained();
            $table->date('tanggal');
            $table->text('alamat');
            $table->unsignedInteger('ongkir');
            $table->string('kurir');
            $table->enum('status', [0, 1, 2, 3]); //0 = Menunggu Pembayaran, 1 = Pembayaran Berhasil 2 = Selesai, 3 = Gagal
            $table->unsignedInteger('total_pembayaran');
            $table->string('snap_token')->nullable()->unique();
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