<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <title>{{ config("app.name") }} @yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <link rel="icon" href="/assets/img/logo/favicon.png" type="image/gif">
    <meta content="Kise Ryota" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link href="/assets/css/app.min.css" rel="stylesheet" />
    <link href="/assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/dotmatri/dotmatri.ttf">
</head>

<body style="background: white">

    <div class="modal-body" style="font-family: Arial, sans-serif !important; font-size: 12px">
        <div class="text-center">
            <h3>UD LOMBOK FROZEN<br>
                <small>Jl. Barcelona V 214 Graha Royal Gunung Sari<br>
                    Telp. 085337755533</small>
            </h3>
        </div>
        <br>
        <br>
        <div class="table-responsive">
            Kepada Yth : {{ $data->pelanggan? $data->pelanggan->nama.' - '.$data->pelanggan->alamat: '-' }}<br>
            No. Faktur : {{ $data->id }}
            <div class="float-right">Tgl. Nota : {{ date('d-m-Y', strtotime($data->tanggal)) }}</div>
            <table class="table">
                <tr>
                    <th class="width-70 p-0">No.</th>
                    <th class="p-0">Barang</th>
                    <th class="width-150 p-0">Harga Satuan</th>
                    <th class="width-70 p-0 text-right">Qty</th>
                    <th class="width-150 p-0 text-right">Diskon</th>
                    <th class="width-150 p-0 text-right">Jum Diskon</th>
                    <th class="width-150 p-0 text-right">Harga</th>
                </tr>
                @foreach ($data->barangKeluarDetail as $index => $row)
                <tr>
                    <td class="p-0">
                        {{ ++$index }}
                    </td>
                    <td class="p-0">
                        {{ $row->barang->nama }}
                    </td>
                    <td class="text-right p-0">
                        {{ number_format($row->harga, 2) }}
                    </td>
                    <td class="p-0 text-right">
                        {{ number_format($row->jumlah) }}
                    </td>
                    <td class="p-0 text-right">
                        {{ number_format($row->diskon) }}
                    </td>
                    <td class="p-0 text-right">
                        {{ number_format($row->diskon*$row->jumlah) }}
                    </td>
                    <td class="text-right p-0">
                        {{ number_format($row->total, 2) }}
                    </td>
                </tr>
                @endforeach
                <tr>
                    <th colspan="6" class="text-right p-0">Total :</th>
                    <th class="text-right p-0">
                        {{ number_format($data->total_tagihan, 2) }}
                    </th>
                </tr>
            </table>
            <table class="" style="width: 100%">
                <tbody>
                    <tr>
                        <td class="text-center">Tanda Terima<br><br><br><br>(.................)</td>
                        <td class="text-center">Hormat Kami<br><br><br><br>UD. LOMBOK FROZEN</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Keluar</button>
        <a href="/barang_keluar/{{$data->id}}" target="_blank" class="btn btn-primary">Cetak</a>
    </div>
    <!-- <script>
        window.print();
    </script> -->
</body>

</html>