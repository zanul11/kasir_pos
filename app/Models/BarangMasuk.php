<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = [];
    protected $table = 'barang_masuk';

    public function barangMasukDetail()
    {
        return $this->hasMany(BarangMasukDetail::class, 'barang_masuk_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('dddd, D MMMM Y') . ' pukul ' . date('H:i', strtotime($value));
    }
}
