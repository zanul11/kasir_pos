<tr id="{{ $id }}">+
    <input type="hidden" name="barang_keluar[{{ $id }}][barang_id]" id="barang_id{{ $id }}" value="{{$barang->id}}" />
    <td class="with-btn width-100">
        <input class="form-control" type="text" name="barang_keluar[{{ $id }}][barang]" id="barang{{ $id }}" value="{{$barang->nama}}" autocomplete="off" readonly />
    </td>
    <td class="with-btn width-100">
        <input class="form-control" type="text" name="barang_keluar[{{ $id }}][satuan]" id="satuan{{ $id }}" value="{{$barang->satuan->nama}}" autocomplete="off" readonly />
    </td>
    <td class="with-btn width-150">
        <input type="text" class="form-control text-right harga hitungan" name="barang_keluar[{{ $id }}][harga]" id="harga{{ $id }}" value="{{$data?$data['harga']:$barang->harga_jual}}" autocomplete="off" readonly />
    </td>
    <td class="with-btn width-100">
        <input class="form-control hitungan qty" id="qty{{ $id }}" onchange="total_harga_barang('{{ $id }}')" onkeyup="total_harga_barang('{{ $id }}')" name="barang_keluar[{{ $id }}][qty]" type="number" value="{{$data?$data['jumlah']:1}}" autocomplete="off" min="1" max="{{$data?$data['jumlah']:$barang->stok}}" required />
    </td>
    <td class="with-btn width-100">
        <input class="form-control hitungan text-right diskon" id="diskon{{ $id }}" onchange="total_harga_barang('{{ $id }}')" onkeyup="total_harga_barang('{{ $id }}')" name="barang_keluar[{{ $id }}][diskon]" type="text" value="{{$data?$data['diskon']:0}}" autocomplete="off" {{$data?'readonly':'required'}} />
    </td>
    <td class="with-btn width-150">
        <input type="text" class="form-control text-right total-harga-barang" id="total_harga{{ $id }}" value="{{$data?$data['total']:$barang->harga_jual}}" autocomplete="off" readonly />
    </td>
    <td class="with-btn align-middle text-center">
        <a class="btn btn-danger mb-2 mr-2 rounded-circle" onclick="hapus_barang('{{ $id }}')">X</a>
    </td>
</tr>