<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kasir;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    protected   $data = [
        'category_name' => 'penjualan',
        'page_name' => 'kasir',
    ];

    public function index()
    {
        return redirect()->route('barang_keluar.create');
    }


    public function create()
    {
        $barangs = Barang::orderby('nama')->get();
        $pelanggans = Pelanggan::orderby('nama')->get();
        return view('pages.penjualan.kasir.index', compact('barangs', 'pelanggans'))->with($this->data);
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Kasir $kasir)
    {
        //
    }


    public function edit(Kasir $kasir)
    {
        //
    }


    public function update(Request $request, Kasir $kasir)
    {
        //
    }


    public function destroy(Kasir $kasir)
    {
        //
    }
}
