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
        Schema::create('barangs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('barcode')->nullable();
            $table->string('nama');
            $table->integer('stok_min')->default(0);
            $table->integer('stok_awal')->default(0);
            $table->integer('stok')->default(0);
            $table->foreignUuid('satuan_id')->constrained('satuans');
            $table->integer('harga_jual')->default(0);
            $table->string('keterangan')->nullable();
            $table->string('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
