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
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->increments('id_kendaraan'); // primary key
            $table->string('tipe', 50)->nullable();
            $table->string('jenis', 50)->nullable();
            $table->string('plat_nomor', 20)->unique()->nullable();
            $table->decimal('harga_perhari', 10, 2)->nullable();
            $table->string('gambar', 100)->nullable();
            $table->string('status', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraan');
    }
};
