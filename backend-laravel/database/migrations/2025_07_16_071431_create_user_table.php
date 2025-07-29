<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id_user'); // primary key dari CI3
            $table->string('nama', 100)->nullable();
            $table->string('email', 100)->unique()->nullable();
            $table->string('password');
            $table->string('no_hp', 15)->nullable();
            $table->text('alamat')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
