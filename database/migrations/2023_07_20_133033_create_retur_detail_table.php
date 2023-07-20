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
        Schema::create('retur_detail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('retur_id')->constrained('retur');
            $table->foreignUuid('barang_id')->constrained('barangs');
            $table->integer('harga')->default(0);
            $table->integer('jumlah')->default(0);
            $table->integer('diskon')->default(0);
            $table->integer('total')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retur_detail');
    }
};
