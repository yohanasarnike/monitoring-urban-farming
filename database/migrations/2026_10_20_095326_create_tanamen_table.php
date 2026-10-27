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
        Schema::create('tanamans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke user yang login
        $table->string('nama_tanaman');
        $table->string('jenis_bibit');
        $table->date('tanggal_tanam');
        $table->string('suhu');
        $table->string('ph_tanah');
        $table->string('kelembapan');
        $table->string('jenis_lahan');
        $table->string('lokasi_penanaman');
        $table->string('tinggi_tanaman');
        $table->string('jenis_pupuk');
        $table->string('kondisi_tanaman');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanamen');
    }
};
