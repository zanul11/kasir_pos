<?php

namespace App\Exports;

use App\Models\BarangKeluar;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Cache;

class PenjualanExport implements FromView
{
    public function view(): View
    {
        $tanggal = date('01-m-Y') . ' - ' . date('d-m-Y');
        $data = null;
        if (Cache::has('dTgl')) {
            $from = date('Y-m-d', strtotime(Cache::get('dTgl')));
            $to = date('Y-m-d', strtotime(Cache::get('sTgl')));
            $tanggal = Cache::get('dTgl') . ' - ' . Cache::get('sTgl');
            $data =  BarangKeluar::with(['pelanggan', 'barangKeluarDetail.barang'])->whereBetween('tanggal', [$from, $to])->get();
        } else {
            $data =  BarangKeluar::with(['pelanggan', 'barangKeluarDetail.barang'])->get();
        }
        return view('excel.export.penjualan', [
            'penjualan' => $data,
            'tanggal' => $tanggal
        ]);
    }
}
