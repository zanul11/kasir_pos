<?php

namespace App\Http\Controllers;

use App\Exports\PenjualanExport;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use  Yajra\Datatables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class PenjualanController extends Controller
{
    protected   $data = [
        'category_name' => 'penjualan',
        'page_name' => 'data_penjualan',
    ];

    public function data()
    {
        if (Cache::has('dTgl')) {
            $from = date('Y-m-d', strtotime(Cache::get('dTgl')));
            $to = date('Y-m-d', strtotime(Cache::get('sTgl')));
            $data =  BarangKeluar::with('barangKeluarDetail.barang')->whereBetween('tanggal', [$from, $to]);
        } else {
            $data =  BarangKeluar::with('barangKeluarDetail.barang');
        }

        if (Cache::has('cari')) {
            $data->with('pelanggan')->whereHas('pelanggan', function ($query) {
                return $query->where('nama', 'like', '%' . Cache::get('cari') . '%');
            })->orderBy('created_at', 'desc');
        } else {
            $data->with('pelanggan')->orderBy('created_at', 'desc');
        }


        return DataTables::of($data)
            ->addColumn('total_tagihan_penjualan', function ($data) {
                return number_format($data->total_tagihan);
            })->addColumn('pelanggan', function ($data) {
                return $data->pelanggan->nama ?? '-';
            })
            ->addColumn('barang_detail', function ($data) {
                $table = '<center><table class=" table-bordered table-striped" style="color:black">
                <tHead>
                <tr>
                <th style="width:35%">Barang</th> <th style="width:20%">Harga</th> <th style="width:5%">Qty</th><th style="width:20%">Diskon</th> <th style="width:20%">Jumlah</th>
                <tr> </tHead>';
                foreach ($data->barangKeluarDetail as $dt) {
                    $table .= '
                    <tr>
                    <td class="text-nowrap">' . $dt->barang->nama . '</td> <td class="text-nowrap text-right">' . number_format($dt->harga) . '</td> <td class="text-nowrap text-right">' . $dt->jumlah . '</td><td>' . number_format($dt->diskon) . '</td> <td class="text-nowrap text-right">' . number_format(($dt->harga - $dt->diskon) * $dt->jumlah) . '</td>
                    <tr>';
                }
                return $table .= '</table></center>';
            })
            ->addColumn('action', function ($data) {

                $print = '<a href="' . route('barang_keluar.show', $data->id) . '" class="text-success" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                </a>';

                $edit = '<a href="' . route('barang_keluar.edit', $data->id) . '" class="text-warning">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-ccw"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg>
                </a>';

                $delete = "<a href='#' onclick='fn_deleteData(" . '"' . route('barang_keluar.destroy', $data->id) . '"' . ")' class='text-danger' title='Hapus Data'>
                <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-trash-2'><polyline points='3 6 5 6 21 6'></polyline><path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path><line x1='10' y1='11' x2='10' y2='17'></line><line x1='14' y1='11' x2='14' y2='17'></line></svg></a>";

                return  $print . ' ' . $edit . ' ' . $delete;
            })
            ->rawColumns(['action', 'barang_detail', 'total_tagihan_penjualan', 'pelanggan'])
            ->make(true);
    }

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
        return view('pages.penjualan.data_penjualan.index')->with($this->data);
    }

    public function export()
    {
        return Excel::download(new PenjualanExport, 'penjualan_' . time() . '.xlsx');
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
