<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = [];
    protected $table = 'barang_keluar';

    public function barangKeluarDetail()
    {
        return $this->hasMany(BarangKeluarDetail::class, 'barang_keluar_id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('dddd, D MMMM Y') . ' pukul ' . date('H:i', strtotime($value));
    }
}
