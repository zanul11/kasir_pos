<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangMasukDetail;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  Yajra\Datatables\DataTables;
use Illuminate\Support\Str;

class BarangMasukController extends Controller
{
    protected   $data = [
        'category_name' => 'barang_masuk',
        'page_name' => 'barang_masuk',
    ];

    public function data()
    {
        $data =  BarangMasuk::with(['supplier', 'barangMasukDetail.barang']);

        return DataTables::of($data)
            // ->addColumn('user_detail', function ($data) {
            //     return '<small> ' . $data->user . '</br>' . $data->updated_at . '</small>';
            // })
            ->addColumn('barang_detal', function ($data) {
                $table = '<center><table class=" table-bordered table-striped" style="color:black">
                <tHead>
                <tr>
                <th style="width:50%">Barang</th> <th style="width:20%">Harga</th> <th style="width:10%">Qty</th> <th style="width:20%">Jumlah</th>
                <tr> </tHead>';
                foreach ($data->barangMasukDetail as $dt) {
                    $table .= '
                    <tr>
                    <td class="text-nowrap">' . $dt->barang->nama . '</td> <td class="text-nowrap text-right">' . number_format($dt->harga) . '</td> <td class="text-nowrap text-right">' . $dt->jumlah . '</td> <td class="text-nowrap text-right">' . number_format($dt->harga * $dt->jumlah) . '</td>
                    <tr>';
                }
                return $table .= '</table></center>';
            })
            ->addColumn('action', function ($data) {
                // $edit = '<a href="' . route('barang_masuk.edit', $data->id) . '" class="text-warning">
                // <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                // </a>';


                $delete = "<a href='#' onclick='fn_deleteData(" . '"' . route('barang_masuk.destroy', $data->id) . '"' . ")' class='text-danger' title='Hapus Data'>
                <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-trash-2'><polyline points='3 6 5 6 21 6'></polyline><path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path><line x1='10' y1='11' x2='10' y2='17'></line><line x1='14' y1='11' x2='14' y2='17'></line></svg></a>";

                return  $delete;
            })
            ->rawColumns(['action', 'barang_detal'])
            ->make(true);
    }

    public function index()
    {
        // return $data =  BarangMasuk::with(['supplier', 'barangMasukDetail.barang'])
        //     ->get();
        return view('pages.barang_masuk.index')->with($this->data);
    }

    public function create()
    {
        $barangs = Barang::orderby('nama')->get();
        $suppliers = Supplier::orderby('nama')->get();
        return view('pages.barang_masuk.create', compact('barangs', 'suppliers'))->with($this->data);
    }


    public function tambah_barang(Request $req, $id)
    {
        $barang = Barang::with('satuan')->where('id', $req->barang_id)->first();
        return view('pages.barang_masuk.barang', [
            'barang' => $barang,
            'id' => $id
        ]);
    }
    public function store(Request $request)
    {
        // return $request;
        $data = [];
        $user = Auth::user()->name;
        try {
            $barang_masuk = BarangMasuk::create([
                'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
                'supplier_id' => $request->supplier_id,
                'user' => $user
            ]);
            // return $barang_masuk;
            foreach ($request->barang_masuk as $barang) {
                $get_stok_now = Barang::where('id', $barang['barang_id'])->first()->stok ?? 0;
                Barang::where('id', $barang['barang_id'])->update(['stok' => $get_stok_now + $barang['qty']]);
                $data[] = [
                    'id' => Str::uuid(),
                    'barang_masuk_id' => $barang_masuk->id,
                    'barang_id' => $barang['barang_id'],
                    'harga' => str_replace(',', '', $barang['harga']),
                    'jumlah' => $barang['qty'],
                    'user' => $user
                ];
            }
            BarangMasukDetail::insert($data);
            alert()->success('Success !!', 'Data berhasil disimpan');
            return redirect()->route('barang_masuk.index');
        } catch (\Throwable $th) {
            alert()->error('Oppss !!', $th->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BarangMasuk $barangMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BarangMasuk $barangMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BarangMasuk $barang_masuk)
    {
        try {
            $barang_detail = BarangMasukDetail::where('barang_masuk_id', $barang_masuk->id)->get();
            foreach ($barang_detail as $dt) {
                $get_stok_now = Barang::where('id', $dt->barang_id)->first()->stok ?? 0;
                Barang::where('id', $dt->barang_id)->update(['stok' => $get_stok_now - $dt->jumlah]);
                BarangMasukDetail::where('id', $dt->id)->delete();
            }
            $barang_masuk->delete();
            alert()->success('Deleted !!', 'Data berhasil dihapus !');
            return response()->json(["success" => "Data berhasil dihapus !"], 200);
        } catch (\Throwable $th) {
            // return $th->getMessage();
            alert()->error('Oppss !!', $th->getMessage());
            return response()->json(["error" => $th->getMessage()], 501);
        }
    }
}
