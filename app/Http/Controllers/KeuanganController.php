<?php

namespace App\Http\Controllers;

use App\Exports\KeuanganExport;
use App\Models\Barang;
use App\Models\BarangKeluarDetail;
use App\Models\BarangMasukDetail;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class KeuanganController extends Controller
{
    protected   $data = [
        'category_name' => 'laporan',
        'page_name' => 'keuangan',
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
        $nama_barang = 'Semua';
        $barangs = Barang::orderby('nama')->get();
        if (isset(request()->barang_id)) {
            Cache::put('barang_id', request()->barang_id);
            $nama_barang = Barang::where('id', request()->barang_id)->first()->nama ?? '';
        } else {
            Cache::forget('barang_id');
        }
        $barangs = Barang::orderBy('nama')->get();
        $data = [];
        if (Cache::has('barang_id') && Cache::get('barang_id') != 'semua') {
            //HITUNG STOK AWAL
            $data_barang = Barang::where('id', Cache::get('barang_id'))->first();
            $stok_awal = $data_barang->stok_awal;
            $barang_masuk = BarangMasukDetail::where('barang_id', Cache::get('barang_id'))
                ->withWhereHas('barangMasuk', function ($q) {
                    return $q->whereDate('tanggal', '<', date('Y-m-d', strtotime(Cache::get('dTgl'))));
                })->sum('jumlah');

            $barang_keluar = BarangKeluarDetail::where('barang_id', Cache::get('barang_id'))
                ->withWhereHas('barangKeluar', function ($q) {
                    return $q->whereDate('tanggal', '<', date('Y-m-d', strtotime(Cache::get('dTgl'))));
                })->sum('jumlah');
            $stok_awal = $stok_awal + $barang_masuk - $barang_keluar;

            //AMBIL DATA Pemasukan DAN BARANG MASUk
            $data_barang_masuk = BarangMasukDetail::where('barang_id', Cache::get('barang_id'))
                ->withWhereHas('barangMasuk', function ($q) {
                    return $q->whereBetween('tanggal', [date('Y-m-d', strtotime(Cache::get('dTgl'))), date('Y-m-d', strtotime(Cache::get('sTgl')))]);
                })->get();
            foreach ($data_barang_masuk as $dt) {
                $data[] = [
                    'nama' => $data_barang->nama,
                    'satuan' => $data_barang->satuan->nama,
                    'stok_awal' => $stok_awal,
                    'status'  => 'Pengeluaran',
                    'tanggal' => $dt->barangMasuk->tanggal,
                    'harga' => $dt->harga,
                    'qty' => $dt->jumlah,
                    'diskon' => 0,
                ];
            }

            $data_barang_keluar = BarangKeluarDetail::where('barang_id', Cache::get('barang_id'))
                ->withWhereHas('barangKeluar', function ($q) {
                    return $q->whereBetween('tanggal', [date('Y-m-d', strtotime(Cache::get('dTgl'))), date('Y-m-d', strtotime(Cache::get('sTgl')))]);
                })->get();
            foreach ($data_barang_keluar as $dt) {
                $data[] = [
                    'nama' => $data_barang->nama,
                    'satuan' => $data_barang->satuan->nama,
                    'stok_awal' => $stok_awal,
                    'status'  => 'Pemasukan',
                    'tanggal' => $dt->barangKeluar->tanggal,
                    'harga' => $dt->harga,
                    'qty' => $dt->jumlah,
                    'diskon' => $dt->diskon,
                ];
            }
            $data = collect($data)->sortBy('tanggal')->values()->all();
        } else {
            foreach ($barangs as $barang) {
                $data_barang = Barang::where('id', $barang->id)->first();
                $stok_awal = $data_barang->stok_awal;
                $barang_masuk = BarangMasukDetail::where('barang_id', $barang->id)
                    ->withWhereHas('barangMasuk', function ($q) {
                        return $q->whereDate('tanggal', '<', date('Y-m-d', strtotime(Cache::get('dTgl'))));
                    })->sum('jumlah');
                $barang_keluar = BarangKeluarDetail::where('barang_id', $barang->id)
                    ->withWhereHas('barangKeluar', function ($q) {
                        return $q->whereDate('tanggal', '<', date('Y-m-d', strtotime(Cache::get('dTgl'))));
                    })->sum('jumlah');
                $stok_awal = $stok_awal + $barang_masuk - $barang_keluar;

                //AMBIL DATA Pemasukan DAN BARANG MASUk
                $data_barang_masuk = BarangMasukDetail::where('barang_id', $barang->id)
                    ->withWhereHas('barangMasuk', function ($q) {
                        return $q->whereBetween('tanggal', [date('Y-m-d', strtotime(Cache::get('dTgl'))), date('Y-m-d', strtotime(Cache::get('sTgl')))]);
                    })->get();
                foreach ($data_barang_masuk as $dt) {
                    $data[] = [
                        'nama' => $data_barang->nama,
                        'satuan' => $data_barang->satuan->nama,
                        'stok_awal' => $stok_awal,
                        'status'  => 'Pengeluaran',
                        'tanggal' => $dt->barangMasuk->tanggal,
                        'harga' => $dt->harga,
                        'qty' => $dt->jumlah,
                        'diskon' => 0,
                    ];
                }

                $data_barang_keluar = BarangKeluarDetail::where('barang_id', $barang->id)
                    ->withWhereHas('barangKeluar', function ($q) {
                        return $q->whereBetween('tanggal', [date('Y-m-d', strtotime(Cache::get('dTgl'))), date('Y-m-d', strtotime(Cache::get('sTgl')))]);
                    })->get();
                foreach ($data_barang_keluar as $dt) {
                    $data[] = [
                        'nama' => $data_barang->nama,
                        'satuan' => $data_barang->satuan->nama,
                        'stok_awal' => $stok_awal,
                        'status'  => 'Pemasukan',
                        'tanggal' => $dt->barangKeluar->tanggal,
                        'harga' => $dt->harga,
                        'qty' => $dt->jumlah,
                        'diskon' => $dt->diskon,
                    ];
                }
                $data = collect($data)->sortBy([
                    ['tanggal', 'asc'],
                ])->values()->all();
            }
        }
        // return $data;
        return view('pages.laporan.keuangan.index', compact('barangs', 'data', 'nama_barang'))->with($this->data);
    }

    public function export()
    {
        return Excel::download(new KeuanganExport, 'Keuangan_' . time() . '.xlsx');
    }
}
