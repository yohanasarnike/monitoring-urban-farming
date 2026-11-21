<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Menambahkan kolom google_id
    public function up(): void
    {
        Schema::table('pemilik_tanaman', function (Blueprint $table) {
            $table->string('google_id')->nullable()->unique();
        });
    }

    // Menghapus kolom google_id jika migration di-rollback
    public function down(): void
    {
        Schema::table('pemilik_tanaman', function (Blueprint $table) {
            $table->dropUnique(['google_id']);
            $table->dropColumn('google_id');
        });
    }
};
