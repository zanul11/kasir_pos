<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = [];

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id');
    }

    public function getStokAttribute()
    {
        $penjualan = BarangKeluarDetail::where('barang_id', $this->id)->sum('jumlah');
        $pembelian = BarangMasukDetail::where('barang_id', $this->id)->sum('jumlah');
        return $this->stok_awal + $pembelian - $penjualan;
    }
}
