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
        Schema::create('barang_masuk_detail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('barang_masuk_id')->constrained('barang_masuk');
            $table->foreignUuid('barang_id')->constrained('barangs');
            $table->integer('harga')->default(0);
            $table->integer('jumlah')->default(0);
            $table->string('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuk_detail');
    }
};
