@extends('layouts.app')

@push('style')
<link rel="stylesheet" type="text/css" href="{{asset('plugins/select2/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
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
                    <h3 class="">Data {{ucwords(str_replace('_', ' ',$page_name))}}</h3>
                    <div>
                        <a href="#" onclick="printKartu()" class="mt-2 edit-profile" style="float: right; margin-left: 10px;">
                            <i data-feather="printer"></i></a><a href="{{route('keuangan.export')}}" class="mt-2 edit-profile2">
                            <i data-feather="file"></i></a>
                    </div>
                </div><br>
                <form action="" method="get" data-parsley-validate="true">
                    <div class="row">
                        <div class="form-group col-lg-3 col-md-4 col-xs-12">
                            <p></p>
                            <input name="tanggal" value="{{(Cache::has('dTgl'))?Cache::get('dTgl').' to '.Cache::get('sTgl'):''}}" class="form-control flatpickr-input active basicFlatpickr" type="text" placeholder="Pilih Tanggal.." required>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                            <p></p>
                            <select name="barang_id" id="barang_id" class=" form-control  @error('barang_id') parsley-error @enderror" data-parsley-required="true" data-live-search="true" data-style="btn-warning">
                                <option value="semua">Semua</option>
                                @foreach($barangs as $item)
                                <option value="{{ $item->id }}" {{(Cache::has('barang_id'))?((Cache::get('barang_id')==$item->id)?'selected':''):''}}>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-2 col-md-2 col-xs-12">
                            <p></p>
                            <button type="submit" class="form-control btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
                @php
                $pengeluaran = 0;
                $pemasukan = 0;
                @endphp
                <div class="table-responsive" id="tableKartuStok">
                    <table class="table table-bordered table-hover table-striped mb-4 " style="width: 100% !important; font-size:8px">

                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
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

                        </thead>
                        <tbody>
                            @foreach($data as $key=>$dt)
                            <tr>
                                <td style="width: 5%">{{$key+1}}</td>
                                <td class="text-center">{{$dt['tanggal']}}</td>
                                <td class="text-center">{{$dt['nama']}}</td>
                                <td class="text-center">{{$dt['satuan']}}</td>
                                <td class="text-center">{{$dt['status']}}</td>
                                <td class="text-center">{{$dt['qty']}}</td>
                                <td class="text-center">{{number_format($dt['harga'])}}</td>
                                <td class="text-center">{{$dt['diskon']}}</td>
                                <td class="text-center">{{($dt['status']=='Pemasukan')?(number_format(($dt['harga']-$dt['diskon'])*$dt['qty'])):'-'}}</td>
                                <td class="text-center">{{($dt['status']=='Pengeluaran')?(number_format(($dt['harga']-$dt['diskon'])*$dt['qty'])):'-'}}</td>
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
                                <td><b>{{number_format($pemasukan)}}</b></td>
                                <td><b>{{number_format($pengeluaran)}}</b></td>
                            </tr>
                        </tbody>
                        <tfoot>


                        </tfoot>

                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
@push('scripts')
@include('inc.swal-delete')
<script src="{{asset('plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('plugins/table/datatable/datatables.js')}}"></script>
<script src="{{asset('assets/js/printThis.js')}}"></script>
<script>
    $('#barang_id').select2({
        placeholder: "Pilih Barang"
    });
    $(".basicFlatpickr").flatpickr({
        mode: "range",
        dateFormat: "d-m-Y",

    });

    function printKartu() {
        $('#tableKartuStok').printThis({
            header: "<center><h4>Laporan Keuangan</h4>" +
                "<h5>{{$nama_barang}}</h5>" +
                "Periode : {{Cache::get('dTgl')}} s.d {{Cache::get('sTgl')}}" +
                "</center><br>"
        });
    }
</script>

@endpush