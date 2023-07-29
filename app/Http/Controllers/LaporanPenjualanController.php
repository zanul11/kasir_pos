<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LaporanPenjualanController extends Controller
{
    protected   $data = [
        'category_name' => 'laporan',
        'page_name' => 'penjualan',
    ];

    public function index()
    {
        if (isset(request()->tanggal)) {
            $tanggal = (explode("to", str_replace(' ', '', request()->tanggal)));
            Cache::put('dTgl', $tanggal[0]);
            Cache::put('sTgl', $tanggal[1] ?? $tanggal[0]);
        } else {
            Cache::put('dTgl', date('01-m-Y'));
            Cache::put('sTgl', date('d-m-Y'));
        }

        if (isset(request()->cari)) {
            Cache::put('cari', request()->cari);
        } else {
            Cache::forget('cari');
        }

        if (isset(request()->pelanggan_id)) {
            Cache::put('pelanggan_id', request()->pelanggan_id);
        } else {
            Cache::forget('pelanggan_id');
        }


        if (Cache::has('dTgl')) {
            $from = date('Y-m-d', strtotime(Cache::get('dTgl')));
            $to = date('Y-m-d', strtotime(Cache::get('sTgl')));
            $data =  BarangKeluar::with('barangKeluarDetail.barang')->whereBetween('tanggal', [$from, $to]);
        } else {
            $data =  BarangKeluar::with('barangKeluarDetail.barang');
        }

        if (Cache::has('pelanggan_id')) {
            $data->where('pelanggan_id', Cache::get('pelanggan_id'));
        }

        if (Cache::has('cari')) {
            $data->with('pelanggan')->whereHas('pelanggan', function ($query) {
                return $query->where('nama', 'like', '%' . Cache::get('cari') . '%');
            })->orderBy('created_at', 'desc');
        } else {
            $data->with('pelanggan')->orderBy('created_at', 'desc');
        }

        $data = $data->get();

        // return $data;
        $pelanggans = Pelanggan::orderBy('nama')->get();
        return view('pages.laporan.penjualan.index', compact('pelanggans', 'data'))->with($this->data);
    }
}
