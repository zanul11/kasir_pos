<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kehadiran;
use App\Models\Pegawai;
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
            $user = User::where('username', $request->username)->with('lokasi')->first();
            return response()->json([
                'response_code' => 200,
                'message' => 'Login Berhasil',
                'conntent' => $user
            ]);
        } else {
            return response()->json([
                'response_code' => 404,
                'message' => 'Username atau Password Tidak Ditemukan!',
                'conntent' => null
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
}
