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
        Schema::create('sewa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wisatawan_id')->constrained('wisatawan')->onDelete('cascade');
            $table->foreignId('kendaraan_id')->constrained('kendaraan')->onDelete('cascade');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->decimal('total_harga', 10, 2);
            $table->decimal('diskon', 10, 2)->nullable(); 
            $table->decimal('harga_setelah_diskon', 10, 2)->nullable();
            $table->enum('status', ['belum_dibayar', 'menunggu_konfirmasi', 'sedang_diproses', 'diterima', 'selesai', 'dibatalkan','perpanjangan sewa']);
            $table->foreignId('jenis_pembayaran_id')->constrained('jenis_pembayaran')->onDelete('cascade');
            $table->string('kode_sewa')->unique();
            $table->enum('metode_pickup', ['diantar', 'ambil_sendiri']);
            $table->text('lokasi_pickup')->nullable();
            $table->string('kode_promo')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sewa');
    }
};
