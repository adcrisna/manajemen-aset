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
        Schema::create('asets', function (Blueprint $table) {
            $table->id();
            $table->string('kode_aset')->nullable();
            $table->string('nama_aset')->nullable();
            $table->string('kategori')->nullable();
            $table->string('lokasi')->nullable();
            $table->date('tanggal_pengadaan')->nullable();
            $table->integer('jumlah')->nullable();
            $table->string('satuan')->nullable();
            $table->decimal('harga_satuan','18','2')->nullable();
            $table->string('tipe_penyusutan')->nullable();
            $table->decimal('harga_perolehan','18','2')->nullable();
            $table->integer('umur_ekonomis')->nullable();
            $table->decimal('nilai_residu','18','2')->nullable();
            $table->decimal('penyusutan_pertahun','18','2')->nullable();
            $table->mediumText('sisa_nilai_penyusutan')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asets');
    }
};
