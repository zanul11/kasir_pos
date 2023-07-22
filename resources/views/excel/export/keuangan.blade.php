<table class="table table-bordered table-hover table-striped mb-4 " style="width: 100% !important; font-size:8px">
    <thead>
        <tr>
            <th>Nomor</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Barang</th>
            <th class="text-center">Satuan</th>
            <th class="text-center">Jenis</th>
            <th class="text-center">Qty</th>
            <th class="text-center">Harga</th>
            <th class="text-center">Diskon</th>
            <th class="text-center">Pemasukan</th>
            <th class="text-center">Pengeluaran</th>
        </tr>
        @php
        $pengeluaran = 0;
        $pemasukan = 0;
        @endphp
    </thead>
    <tbody>
        @foreach($keuangan as $key=>$dt)
        <tr>
            <td>{{$key+1}}</td>
            <td class="text-center">{{$dt['tanggal']}}</td>
            <td class="text-center">{{$dt['nama']}}</td>
            <td class="text-center">{{$dt['satuan']}}</td>
            <td class="text-center">{{$dt['status']}}</td>
            <td class="text-center">{{$dt['qty']}}</td>
            <td class="text-center">{{$dt['harga']}}</td>
            <td class="text-center">{{$dt['diskon']}}</td>
            <td class="text-center">{{($dt['status']=='Pemasukan')?(($dt['harga']-$dt['diskon'])*$dt['qty']):'-'}}</td>
            <td class="text-center">{{($dt['status']=='Pengeluaran')?(($dt['harga']-$dt['diskon'])*$dt['qty']):'-'}}</td>
        </tr>
        @if($dt['status']=='Pemasukan')
        @php
        $pemasukan +=(($dt['harga']-$dt['diskon'])*$dt['qty']);
        @endphp
        @else
        @php
        $pengeluaran +=(($dt['harga']-$dt['diskon'])*$dt['qty']);
        @endphp
        @endif
        @endforeach
        <tr>
            <td colspan="8"><b>Total</b></td>
            <td><b>{{$pemasukan}}</b></td>
            <td><b>{{$pengeluaran}}</b></td>
        </tr>
    </tbody>
    <tfoot>

    </tfoot>

</table>