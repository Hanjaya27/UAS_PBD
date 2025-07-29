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
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->increments('id_pemesanan'); // primary key dari CI3
            $table->unsignedInteger('id_user')->nullable();
            $table->unsignedInteger('id_kendaraan')->nullable();
            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->decimal('total_harga', 10, 2)->nullable();
            $table->string('status', 50)->default('diproses');

            // Relasi ke user & kendaraan
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('set null');
            $table->foreign('id_kendaraan')->references('id_kendaraan')->on('kendaraan')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
