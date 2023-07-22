<table>
    <thead>
        <tr>
            <th rowspan="2">Nomor</th>
            <th class="text-center" rowspan="2">Tanggal</th>
            <th class="text-center" rowspan="2">Keterangan</th>
            <th class="text-center" colspan="7">Kartu Barang</th>
            <th class="text-center" rowspan="2">Sisa</th>
        </tr>
        <tr>
            <th class="text-center">Masuk</th>
            <th class="text-center">Harga Beli</th>
            <th class="text-center">Total</th>
            <th class="text-center">Keluar</th>
            <th class="text-center">Harga Penjualan</th>
            <th class="text-center">Diskon</th>
            <th class="text-center">Total</th>
        </tr>
    </thead>
    @php
    $nama_barang = '';
    $i='A';
    $x=1;
    $stok = 0;
    $pembelian = 0;
    $penjualan = 0;
    @endphp
    <tbody>
        @foreach($kartu_stok as $key => $dt)

        @if($key!=0 && $nama_barang!=$dt['nama'])
        <tr>
            <td colspan="3"><b>TOTAL</b></td>
            <td><b>{{$total_masuk}}</b></td>
            <td></td>
            <td><b>{{$pembelian}}</b></td>
            <td><b>{{$total_keluar}}</b></td>
            <td></td>
            <td></td>
            <td><b>{{$penjualan}}</b></td>
            <td>{{$stok}}</td>
        </tr>
        <tr>
            <td colspan="11"></td>

        </tr>
        @endif

        @if($nama_barang!=$dt['nama'])

        @php
        $x=1;
        $total_masuk =0;
        $total_keluar=0;
        $pembelian=0;
        $penjualan=0;
        $stok = $dt['stok_awal'];

        @endphp

        <tr>
            <td rowspan="2">{{$i}}</td>
            <td colspan="10" class="text-left"><b>{{$dt['nama']}} </b></td>
        </tr>
        <tr>
            <td colspan="10" class="text-left"><b>Stok Awal : {{$dt['stok_awal']}}</b></td>
        </tr>
        @endif
        <tr>
            <td>{{$x++}}</td>
            <td>{{$dt['tanggal']}}</td>
            <td>{{$dt['status']}}</td>
            @if($dt['status']=='Pembelian')
            @php
            $stok +=$dt['qty'];
            $pembelian+=($dt['qty']*$dt['harga']);
            $total_masuk+=$dt['qty'];
            @endphp
            <td>{{$dt['qty']}}</td>
            <td>{{$dt['harga']}}</td>
            <td>{{$dt['qty']*$dt['harga']}}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{$stok}}</td>
            @else
            @php
            $total_keluar+=$dt['qty'];
            $stok -=$dt['qty'];
            $penjualan+=($dt['qty']*($dt['harga']-$dt['diskon']));
            @endphp
            <td></td>
            <td></td>
            <td></td>
            <td>{{$dt['qty']}}</td>
            <td>{{$dt['harga']}}</td>
            <td>{{$dt['diskon']}}</td>
            <td>{{$dt['qty']*($dt['harga']-$dt['diskon'])}}</td>
            <td>{{$stok}}</td>
            @endif
        </tr>
        @if($loop->last)
        <tr>
            <td colspan="3"><b>TOTAL</b></td>
            <td><b>{{$total_masuk}}</b></td>
            <td></td>
            <td><b>{{$pembelian}}</b></td>
            <td><b>{{$total_keluar}}</b></td>
            <td></td>
            <td></td>
            <td><b>{{$penjualan}}</b></td>
            <td>{{$stok}}</td>
        </tr>
        @endif
        @if($nama_barang!=$dt['nama'])
        @php
        $i++;
        $nama_barang = $dt['nama'];
        @endphp
        @endif
        @endforeach

    </tbody>
</table>