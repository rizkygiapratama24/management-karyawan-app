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
        Schema::create('role_based', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('akses_tambah');
            $table->integer('akses_edit');
            $table->integer('akses_hapus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_based');
    }
};
