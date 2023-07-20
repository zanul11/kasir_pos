<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retur extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = [];
    protected $table = 'retur';

    public function barangKeluar()
    {
        return $this->belongsTo(BarangKeluar::class, 'barang_keluar_id');
    }

    public function returDetail()
    {
        return $this->hasMany(ReturDetail::class, 'retur_id');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('dddd, D MMMM Y') . ' pukul ' . date('H:i', strtotime($value));
    }
}
