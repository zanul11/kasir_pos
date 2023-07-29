@extends('layouts.app')

@push('style')
<link rel="stylesheet" type="text/css" href="{{asset('plugins/select2/select2.min.css')}}">
<link href="{{asset('plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
<style>
    td {
        text-align: center;
    }
</style>
@endpush
@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 user-profile layout-spacing">
            <div class="widget-content widget-content-area">
                <div class="d-flex justify-content-between">
                    <!-- <h5 class="">Data {{ucwords($page_name)}}</h5> -->
                    <h3 class="">{{ucwords(str_replace('_', ' ',$page_name))}}</h3>
                    <div>
                        <a href="#" onclick="printPenjualan()" class="mt-2 edit-profile">
                            <i data-feather="printer"></i></a>
                    </div>

                </div><br>

                <form action="" method="get" data-parsley-validate="true">
                    <div class="row">
                        <div class="form-group col-lg-3 col-md-4 col-xs-12">
                            <p></p>
                            <input name="tanggal" value="{{(Cache::has('dTgl'))?Cache::get('dTgl').' to '.Cache::get('sTgl'):''}}" class="form-control flatpickr-input active basicFlatpickr" type="text" placeholder="Pilih Tanggal.." required>
                        </div>
                        <div class="form-group col-lg-3 col-md-4 col-xs-12">
                            <p></p>
                            <input name="cari" value="{{(Cache::has('cari'))?Cache::get('cari'):''}}" placeholder="Cari..." class="form-control" type="text">
                        </div>
                        <div class="col-lg-4 col-md-12 col-xs-12 form-group">
                            <p></p>
                            <select name="pelanggan_id" id="pelanggan_id" class=" form-control  @error('pelanggan_id') parsley-error @enderror" data-parsley-required="true" data-live-search="true" data-style="btn-warning">
                                <option value="">Pilih Pelanggan</option>
                                @foreach($pelanggans as $item)
                                <option value="{{ $item->id }}" {{ (Cache::get('pelanggan_id')==$item->id) ? 'selected' : '' }}>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-2 col-md-2 col-xs-12">
                            <p></p>
                            <button type="submit" class="form-control btn-primary">Filter</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive" id="tablePenjualan">
                    <table class="table table-bordered table-hover " style="width: 100% !important; font-size:8px">
                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th class="text-center">Waktu Input</th>
                                <th class="text-center">Pelanggan</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Barang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total=0;
                            @endphp
                            @foreach($data as $data)
                            @php
                            $total+=$data->total_tagihan;
                            @endphp
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$data->updated_at}}</td>
                                <td>{{$data->pelanggan->nama??'-'}}</td>
                                <td>{{$data->keterangan}}</td>
                                <td>{{number_format($data->total_tagihan)}}</td>
                                <td>
                                    <table>
                                        <tbody>

                                            <tr>
                                                <th tyle="width:35%">Barang</th>
                                                <th style="width:20%">Harga</th>
                                                <th style="width:5%">Qty</th>
                                                <th style="width:20%">Diskon</th>
                                                <th>Jumlah</th>
                                            </tr>
                                            @foreach ($data->barangKeluarDetail as $barang)
                                            <tr>
                                                <td>{{$barang->barang->nama}}</td>
                                                <td>{{number_format($barang->harga)}}</td>
                                                <td>{{$barang->jumlah}}</td>
                                                <td>{{$barang->diskon}}</td>
                                                <td>{{number_format(($barang->harga-$barang->diskon) * $barang->jumlah)}}</td>
                                            </tr>
                                            @endforeach
                                        <tbody>
                                    </table>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="4"><b>Total</b></td>
                                <td><b>{{number_format($total)}}</b></td>
                                <td><b></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> -->
<!-- <script src="{{asset('plugins/table/datatable/datatables.js')}}"></script> -->
@push('scripts')
@include('inc.swal-delete')
<script src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/js/printThis.js')}}"></script>

<script>
    $('#pelanggan_id').select2({
        placeholder: "Pilih Pelanggan"
    });
    $(".basicFlatpickr").flatpickr({
        mode: "range",
        dateFormat: "d-m-Y",
    });

    function printPenjualan() {
        $('#tablePenjualan').printThis({
            header: "<center><h4>Laporan Penjualan</h4>" +
                "Periode : {{Cache::get('dTgl')}} s.d {{Cache::get('sTgl')}}" +
                "</center><br>"
        });
    }
</script>

@endpush