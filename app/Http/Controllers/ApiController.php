<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangKeluarDetail;
use Illuminate\Support\Str;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $login = Auth::attempt($request->all());
        if ($login) {
            $user = User::where('username', $request->username)->first();
            return response()->json([
                'response_code' => 200,
                'message' => 'Login Berhasil',
                'content' => $user
            ]);
        } else {
            return response()->json([
                'response_code' => 404,
                'message' => 'Username atau Password Tidak Ditemukan!',
                'content' => null
            ]);
        }
    }

    public function getBarang()
    {
        return response()->json([
            'response_code' => 200,
            'message' => 'success',
            'content' => Barang::with('satuan')->orderBy('nama')->get()
        ]);
    }
    public function getPelanggan()
    {
        return response()->json([
            'response_code' => 200,
            'message' => 'success',
            'content' => Pelanggan::orderBy('nama')->get()
        ]);
    }

    public function savePenjualan(Request $request)
    {
        // return json_decode($request->penjualans);
        // return response()->json([
        //     'response_code' => 200,
        //     'message' => 'success',
        //     'content' => Pelanggan::orderBy('nama')->get()
        // ]);
        $data = [];
        $user = $request->user;
        $total_tagihan = 0;
        try {
            $barang_keluar = BarangKeluar::create([
                'tanggal' => date('Y-m-d'),
                'keterangan' => 'Kasir Mobile',
                'pelanggan_id' => $request->pelanggan_id,
                'total_tagihan' => 0,
                'user' => $user
            ]);

            foreach (json_decode($request->penjualans) as $barang) {
                $data_barang = Barang::where('id', $barang->barang_id)->first();
                $get_stok_now = $data_barang->stok ?? 0;
                if ($get_stok_now < $barang->qty) {
                    BarangKeluar::where('id', $barang_keluar->id)->delete();
                    //stok kurang
                    return response()->json([
                        'response_code' => 201,
                        'message' => 'Stok ' . $data_barang->nama . ' kurang!',
                    ]);
                }
                Barang::where('id', $barang->barang_id)->update(['stok' => $get_stok_now - $barang->qty]);
                $data[] = [
                    'id' => Str::uuid(),
                    'barang_keluar_id' => $barang_keluar->id,
                    'barang_id' => $barang->barang_id,
                    'harga' =>  $barang->harga,
                    'jumlah' => $barang->qty,
                    'diskon' =>  $barang->diskon,
                    'total' => (($barang->harga) -  $barang->diskon) * $barang->qty,
                ];
                $total_tagihan += (($barang->harga) -  $barang->diskon) * $barang->qty;
            }
            BarangKeluarDetail::insert($data);
            BarangKeluar::where('id', $barang_keluar->id)->update(['total_tagihan' => $total_tagihan]);
            return response()->json([
                'response_code' => 200,
                'message' => 'success',
            ]);
        } catch (\Throwable $th) {
            BarangKeluar::where('id', $barang_keluar->id)->delete();
            return response()->json([
                'response_code' => 201,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
