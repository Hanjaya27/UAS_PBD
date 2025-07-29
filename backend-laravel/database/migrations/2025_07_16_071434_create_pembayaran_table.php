<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->increments('id_pembayaran'); // PK dari CI3
            $table->unsignedInteger('id_pemesanan')->nullable();
            $table->date('tgl_bayar')->nullable();
            $table->decimal('jml_bayar', 10, 2)->nullable();
            $table->string('metode', 50)->nullable(); // misalnya: Qris, Tunai, TF
            $table->string('status', 50)->nullable(); // misalnya: lunas, belum lunas
            $table->string('bukti_bayar', 255)->nullable();

            // Foreign Key
            $table->foreign('id_pemesanan')
                  ->references('id_pemesanan')
                  ->on('pemesanan')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
