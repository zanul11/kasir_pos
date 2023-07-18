<?php

namespace App\Http\Livewire;

use App\Models\Barang;
use Livewire\Component;

class BarangMasuk extends Component
{
    public $barangs = [];
    public $barang_masuk = [];
    public $barangId;

    public function mount()
    {
        $this->barangs = Barang::orderby('nama')->get();
    }

    public function render()
    {
        $this->emit('reinit');
        return view('livewire.barang-masuk');
    }

    public function updatedBarangId($value)
    {
        $barang = Barang::with('satuan')->where('id', $value)->first();
        $this->barang_masuk[] = [
            "barang_id" => $value,
            "nama" => $barang->nama,
            "satuan" => $barang->satuan->nama,
            "harga" => 0,
            "qty" => 1,

        ];
    }
}
