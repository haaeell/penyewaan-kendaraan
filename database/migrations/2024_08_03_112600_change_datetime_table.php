<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('sewa', function (Blueprint $table) {
            $table->datetime('tanggal_mulai')->change();
            $table->datetime('tanggal_selesai')->change();
        });
    }

    public function down()
    {
        Schema::table('sewa', function (Blueprint $table) {
            $table->date('tanggal_mulai')->change();
            $table->date('tanggal_selesai')->change();
        });
    }
};
