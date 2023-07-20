<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangKeluarDetail;
use App\Models\Pelanggan;
use App\Models\Retur;
use App\Models\ReturDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BarangKeluarController extends Controller
{

    protected   $data = [
        'category_name' => 'penjualan',
        'page_name' => 'barang_keluar',
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

    public function tambah_barang(Request $req, $id)
    {

        $barang = Barang::with('satuan')->where('id', $req->barang_id)->first();
        $data = $req->barang_keluar ?? null;
        return view('pages.penjualan.kasir.barang', [
            'data' => $data,
            'barang' => $barang,
            'id' => $id
        ]);
    }


    public function store(Request $request)
    {
        // return $request;
        if (!$request->has('barang_keluar')) {
            alert()->error('Oppss !!', 'Gagal input penjualan!');
            return back()->withInput();
        }
        $data = [];
        $user = Auth::user()->name;
        $total_tagihan = 0;
        try {
            $barang_keluar = BarangKeluar::create([
                'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
                'keterangan' => $request->keterangan ?? '-',
                'pelanggan_id' => $request->pelanggan_id,
                'total_tagihan' => 0,
                'user' => $user
            ]);

            foreach ($request->barang_keluar as $barang) {
                $data_barang = Barang::where('id', $barang['barang_id'])->first();
                $get_stok_now = $data_barang->stok ?? 0;
                if ($get_stok_now < $barang['qty']) {
                    //cek stok masih ada dengan pembelian
                    BarangKeluar::where('id', $barang_keluar->id)->delete();
                    alert()->error('Oppss !!', 'Stok ' . $data_barang->nama . ' kurang!');
                    return back()->withInput();
                }
                Barang::where('id', $barang['barang_id'])->update(['stok' => $get_stok_now - $barang['qty']]);
                $data[] = [
                    'id' => Str::uuid(),
                    'barang_keluar_id' => $barang_keluar->id,
                    'barang_id' => $barang['barang_id'],
                    'harga' => str_replace(',', '', $barang['harga']),
                    'jumlah' => $barang['qty'],
                    'diskon' => str_replace(',', '', $barang['diskon']),
                    'total' => ((str_replace(',', '', $barang['harga']) - str_replace(',', '', $barang['diskon'])) * $barang['qty']),
                ];
                $total_tagihan += ((str_replace(',', '', $barang['harga']) - str_replace(',', '', $barang['diskon'])) * $barang['qty']);
            }
            BarangKeluarDetail::insert($data);
            BarangKeluar::where('id', $barang_keluar->id)->update(['total_tagihan' => $total_tagihan]);
            alert()->success('Success !!', 'Data berhasil disimpan');
            return redirect()->route('barang_keluar.create')->with(['kwitansi' => '/barang_keluar/' . $barang_keluar->id]);
        } catch (\Throwable $th) {
            alert()->error('Oppss !!', $th->getMessage());
            return back()->withInput();
        }
    }


    public function show(BarangKeluar $barang_keluar)
    {
        $data = $barang_keluar;
        return view('pages.penjualan.kasir.kwitansi', compact('data'))->with($this->data);
    }


    public function edit(BarangKeluar $barang_keluar)
    {
        // return json_encode($barang_keluar->barangKeluarDetail);
        $barangs = Barang::orderby('nama')->get();
        $pelanggans = Pelanggan::orderby('nama')->get();
        return view('pages.penjualan.kasir.index', compact('barangs', 'pelanggans', 'barang_keluar'))->with($this->data);
    }


    public function update(Request $request, BarangKeluar $barang_keluar)
    {
        // return $barang_keluar;
        // return $request;
        if (!$request->has('barang_keluar')) {
            alert()->error('Oppss !!', 'Gagal melakukan retur!');
            return back()->withInput();
        }

        $data_retur = Retur::create([
            'barang_keluar_id' => $barang_keluar->id,
            'user' => Auth::user()->name,
        ]);
        $cekAdaRetur = false;
        $data_hapus = array();

        foreach ($request->barang_keluar as $barang) {
            array_push($data_hapus, $barang['barang_id']);
            $get_barang_keluar_detail = BarangKeluarDetail::where('barang_keluar_id', $barang_keluar->id)
                ->where('barang_id', $barang['barang_id'])->first();
            if ($barang['qty'] > $get_barang_keluar_detail->jumlah) {
                Retur::where('id', $data_retur->id)->delete();
                alert()->error('Oppss !!', 'Stok ' . $get_barang_keluar_detail->barang->nama . ' anda tambahkan!');
                return back()->withInput();
            } else if ($barang['qty'] < $get_barang_keluar_detail->jumlah) {
                //update jumlah retur ke penjualan
                $cekAdaRetur = true;
                $selisih_retur = $get_barang_keluar_detail->jumlah - $barang['qty'];
                BarangKeluarDetail::where('barang_keluar_id', $barang_keluar->id)
                    ->where('barang_id', $barang['barang_id'])->update([
                        'jumlah' => ($get_barang_keluar_detail->jumlah - $selisih_retur),
                        'total' => ($get_barang_keluar_detail->harga - $get_barang_keluar_detail->diskon) * ($get_barang_keluar_detail->jumlah - $selisih_retur)
                    ]);
                //update total tagihan barang keluar/penjulan
                $barang_keluar->total_tagihan = $barang_keluar->total_tagihan - (($get_barang_keluar_detail->harga - $get_barang_keluar_detail->diskon) * $selisih_retur);
                $barang_keluar->save();

                //update data barang (stok)
                $data_barang_real = Barang::where('id', $barang['barang_id'])->first();
                Barang::where('id', $barang['barang_id'])->update(['stok' => $data_barang_real->stok + $selisih_retur]);

                //input log retur
                $data[] = [
                    'id' => Str::uuid(),
                    'retur_id' => $data_retur->id,
                    'barang_id' => $barang['barang_id'],
                    'harga' => str_replace(',', '', $barang['harga']),
                    'jumlah' => $barang['qty'],
                    'diskon' => str_replace(',', '', $barang['diskon']),
                    'total' => ((str_replace(',', '', $barang['harga']) - str_replace(',', '', $barang['diskon'])) * $barang['qty']),
                ];
            }
        }
        //apakah ada barang yang dihapus?
        $result_hapus = $barang_keluar->barangKeluarDetail->pluck('barang_id')->diff($data_hapus);
        foreach ($result_hapus as $item) {
            $cekAdaRetur = true;
            $get_barang_keluar_detail = BarangKeluarDetail::where('barang_keluar_id', $barang_keluar->id)
                ->where('barang_id', $item)->first();
            //input log retur
            $data[] = [
                'id' => Str::uuid(),
                'retur_id' => $data_retur->id,
                'barang_id' => $item,
                'harga' => $get_barang_keluar_detail->harga,
                'jumlah' => $get_barang_keluar_detail->jumlah,
                'diskon' => $get_barang_keluar_detail->diskon,
                'total' => $get_barang_keluar_detail->total,
            ];
            //update total tagihan barang keluar/penjulan
            $barang_keluar->total_tagihan = $barang_keluar->total_tagihan - $get_barang_keluar_detail->total;
            $barang_keluar->save();
            //update stok barang
            $data_barang_real = Barang::where('id', $item)->first();
            Barang::where('id', $item)->update(['stok' => $data_barang_real->stok + $get_barang_keluar_detail->jumlah]);
            BarangKeluarDetail::where('barang_keluar_id', $barang_keluar->id)
                ->where('barang_id', $item)->delete();
        }
        if (!$cekAdaRetur) {
            Retur::where('id', $data_retur->id)->delete();
        }
        ReturDetail::insert($data);
        alert()->success('Success !!', 'Data berhasil disimpan');
        return redirect()->route('data_penjualan.index');

        return $request;
    }

    public function destroy(BarangKeluar $barang_keluar)
    {
        try {
            $barang_detail = BarangKeluarDetail::where('barang_keluar_id', $barang_keluar->id)->get();
            foreach ($barang_detail as $dt) {
                $get_stok_now = Barang::where('id', $dt->barang_id)->first()->stok ?? 0;
                Barang::where('id', $dt->barang_id)->update(['stok' => $get_stok_now + $dt->jumlah]);
                BarangKeluarDetail::where('id', $dt->id)->delete();
            }
            $barang_keluar->delete();
            alert()->success('Deleted !!', 'Data berhasil dihapus !');
            return response()->json(["success" => "Data berhasil dihapus !"], 200);
        } catch (\Throwable $th) {
            // return $th->getMessage();
            alert()->error('Oppss !!', $th->getMessage());
            return response()->json(["error" => $th->getMessage()], 501);
        }
    }
}
