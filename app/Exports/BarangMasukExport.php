<?php

namespace App\Exports;

use App\Models\BarangMasuk;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Cache;


class BarangMasukExport implements FromView
{
    public function view(): View
    {
        $data = null;
        if (Cache::has('dTgl')) {
            $from = date('Y-m-d', strtotime(Cache::get('dTgl')));
            $to = date('Y-m-d', strtotime(Cache::get('sTgl')));
            $data =  BarangMasuk::with(['supplier', 'barangMasukDetail.barang'])->whereBetween('tanggal', [$from, $to])->get();
        } else {
            $data =  BarangMasuk::with(['supplier', 'barangMasukDetail.barang'])->get();
        }
        return view('excel.export.barang_masuk', [
            'barang_masuk' => $data,
        ]);
    }
}
