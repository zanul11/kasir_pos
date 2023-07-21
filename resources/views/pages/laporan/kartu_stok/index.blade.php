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
                        <a href="" class="mt-2 edit-profile2" style="float: right; margin-left: 10px;">
                            <i data-feather="printer"></i></a>
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
                $nama_barang = ''; $stok = 0;
                @endphp
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped mb-4 " style="width: 100% !important; font-size:8px">
                        @if(Cache::has('barang_id') && Cache::get('barang_id') != 'semua')
                        <thead>
                            <tr>
                                <th style="width: 5%" rowspan="2">#</th>
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
                        <tbody>
                            @foreach($data as $key => $dt)

                            @if($nama_barang!=$dt['nama'])
                            @php
                            $stok = $dt['stok_awal'];
                            $nama_barang = $dt['nama'];
                            @endphp
                            <tr>

                                <td colspan="6"><b>{{$dt['nama']}} </b></td>
                                <td colspan="5"><b>Stok Awal : {{$dt['stok_awal']}}</b></td>

                            </tr>
                            @endif

                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$dt['tanggal']}}</td>
                                <td>{{$dt['status']}}</td>
                                @if($dt['status']=='Pembelian')
                                @php
                                $stok +=$dt['qty'];
                                @endphp
                                <td>{{$dt['qty']}}</td>
                                <td>{{number_format($dt['harga'])}}</td>
                                <td>{{number_format($dt['qty']*$dt['harga'])}}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$stok}}</td>
                                @else
                                @php
                                $stok -=$dt['qty'];
                                @endphp
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$dt['qty']}}</td>
                                <td>{{number_format($dt['harga'])}}</td>
                                <td>{{$dt['diskon']}}</td>
                                <td>{{number_format($dt['qty']*($dt['harga']-$dt['diskon']))}}</td>
                                <td>{{$stok}}</td>
                                @endif
                            </tr>

                            @endforeach
                        </tbody>
                        @else
                        <thead>
                            <tr>
                                <th style="width: 5%" rowspan="2">#</th>
                                <th class="text-center" rowspan="2">Nama Barang</th>
                                <th class="text-center" rowspan="2">Satuan</th>
                                <th class="text-center" colspan="3">Kartu Barang</th>
                            </tr>
                            <tr>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Masuk</th>
                                <th class="text-center">Keluar</th>
                                <th class="text-center">Sisa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $key => $dt)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$dt['nama']}}</td>
                                <td>{{$dt['satuan']}}</td>
                                <td>{{$dt['stok_awal']}}</td>
                                <td>{{$dt['barang_masuk']}}</td>
                                <td>{{$dt['barang_keluar']}}</td>
                                <td>{{$dt['stok_awal']+$dt['barang_masuk']-$dt['barang_keluar']}}</td>
                            </tr>

                            @endforeach
                        </tbody>
                        @endif
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
<script>
    $('#barang_id').select2({
        placeholder: "Pilih Barang"
    });
    $(".basicFlatpickr").flatpickr({
        mode: "range",
        dateFormat: "d-m-Y",

    });
</script>

@endpush