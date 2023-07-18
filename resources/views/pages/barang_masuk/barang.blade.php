<tr id="{{ $id }}">

    <input type="hidden" name="barang_masuk[{{ $id }}][barang_id]" id="barang_id{{ $id }}" value="{{$barang->id}}" />

    <td class="with-btn width-100">
        <input class="form-control" type="text" name="barang_masuk[{{ $id }}][barang]" id="barang{{ $id }}" value="{{$barang->nama}}" autocomplete="off" readonly />
    </td>
    <td class="with-btn width-100">
        <input class="form-control" type="text" name="barang_masuk[{{ $id }}][satuan]" id="satuan{{ $id }}" value="{{$barang->satuan->nama}}" autocomplete="off" readonly />
    </td>
    <td class="with-btn width-150">
        <input type="text" class="form-control text-right harga hitungan" name="barang_masuk[{{ $id }}][harga]" id="harga{{ $id }}" value="0" autocomplete="off" required />
    </td>
    <td class="with-btn width-100">
        <input class="form-control hitungan qty" id="qty{{ $id }}" name="barang_masuk[{{ $id }}][qty]" type="number" value="1" autocomplete="off" min="1" required />
    </td>
    <td class="with-btn width-150">
        <input type="text" class="form-control text-right total-harga" id="total_harga{{ $id }}" value="0" autocomplete="off" readonly />
    </td>
    <td class="with-btn align-middle">
        <button class="btn btn-danger mb-2 mr-2 rounded-circle hapus-barang">X</button>
    </td>
</tr>