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
        Schema::table('jadwal', function (Blueprint $table) {
            $table->text('catatan')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->text('catatan')->nullable(false)->change();
        });
    }
};
