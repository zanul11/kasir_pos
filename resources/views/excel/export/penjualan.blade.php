<p>Laporan Penjualan</p>
<p>Waktu : {{$tanggal}}</p>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Kode</th>
            <th>Waktu Input</th>
            <th>Pelanggan</th>
            <th>Keterangan</th>
            <th>Jumlah</th>
            <th>Barang</th>
        </tr>
    </thead>
    <tbody>
        @foreach($penjualan as $key => $dt)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$dt->id}}</td>
            <td>{{$dt->updated_at}}</td>
            <td>{{$dt->pelanggan->nama??''}}</td>
            <td>{{$dt->keterangan??''}}</td>
            <td>{{$dt->total_tagihan}}</td>
            <td>
                <table>
                    <tbody>
                        <tr colspan="5">
                            <th>Daftar Penjualan</th>
                        </tr>
                        <tr>
                            <th>Barang</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Diskon</th>
                            <th>Jumlah</th>
                        </tr>
                        @foreach ($dt->barangKeluarDetail as $barang)
                        <tr>
                            <td>{{$barang->barang->nama}}</td>
                            <td>{{$barang->harga}}</td>
                            <td>{{$barang->jumlah}}</td>
                            <td>{{$barang->diskon}}</td>
                            <td>{{($barang->harga-$barang->diskon) * $barang->jumlah}}</td>
                        </tr>
                        @endforeach
                    <tbody>
                </table>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>