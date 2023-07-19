<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Kode</th>
            <th>Waktu Input</th>
            <th>Supplier</th>
            <th>Barang</th>
        </tr>
    </thead>
    <tbody>
        @foreach($barang_masuk as $key => $dt)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$dt->id}}</td>
            <td>{{$dt->updated_at}}</td>
            <td>{{$dt->supplier->nama}}</td>
            <td>
                <table>
                    <tbody>
                        <tr>
                            <th>Barang</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Jumlah</th>
                        </tr>
                        @foreach ($dt->barangMasukDetail as $barang)
                        <tr>
                            <td>{{$barang->barang->nama}}</td>
                            <td>{{number_format($barang->harga)}}</td>
                            <td>{{$barang->jumlah}}</td>
                            <td>{{number_format($barang->harga * $barang->jumlah)}}</td>
                        </tr>
                        @endforeach
                    <tbody>
                </table>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>