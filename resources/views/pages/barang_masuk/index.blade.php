@extends('layouts.app')

@push('style')
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
                            <i data-feather="file"></i></a> <a href="{{route('barang_masuk.create')}}" class="mt-2 edit-profile">
                            <i data-feather="plus"></i></a>
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
                            <button type="submit" class="form-control btn-primary">Filter Tanggal</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered table-hover " style="width: 100% !important; font-size:8px">
                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <!-- <th>Kode</th> -->
                                <th class="text-center">Waktu Input</th>
                                <th class="text-center">Supplier</th>
                                <th class="text-center">Barang</th>
                                <th style="width: 5% !important;" class="text-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
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
<script src="{{asset('plugins/table/datatable/datatables.js')}}"></script>
<script>
    $(".basicFlatpickr").flatpickr({
        mode: "range",
        dateFormat: "d-m-Y",

    });
    $('#datatable').DataTable({
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Data _START_ sampai _END_ dari _TOTAL_ data.",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Cari...",
            "sLengthMenu": "Results :  _MENU_",
        },
        processing: true,
        serverSide: true,
        responsive: true,
        lengthChange: true,
        ordering: false,
        ajax: "{!! route('barang_masuk.data') !!}",
        columns: [{
                data: 'id',
                name: 'id',
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            // {
            //     data: 'id',
            //     name: 'id'
            // },
            {
                data: 'updated_at',
                name: 'updated_at'
            }, {
                data: 'supplier.nama',
                name: 'supplier.nama'
            },
            {
                data: 'barang_detal',
                name: 'barang_detal',
                className: "text-center"
            },
            {
                data: 'action',
                name: 'action'
            }
        ],

        render: function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }
    });
</script>

@endpush