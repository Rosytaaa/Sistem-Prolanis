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
        Schema::create('hasillab', function (Blueprint $table) {
            $table->string('no_bpjs');
            $table->string('nama');
            $table->text('keterangan');
            $table->date('tanggal_pemeriksaan');
            $table->text('hasil_lab');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasillab');
    }
};
