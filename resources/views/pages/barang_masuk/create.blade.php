@extends('layouts.app')
@push('style')
<link rel="stylesheet" type="text/css" href="{{asset('plugins/select2/select2.min.css')}}">
<link href="{{asset('plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
@endpush
@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 user-profile layout-spacing">
            <div class="widget-content widget-content-area">
                <div class="d-flex justify-content-between">
                    <!-- <h5 class="">Data {{ucwords($page_name)}}</h5> -->
                    <h3 class="">Form Data {{ucwords(str_replace('_', ' ',$page_name))}}</h3>
                    <a href="{{route('barang_masuk.index')}}" class="mt-2 edit-profile">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg></a>
                </div><br>
                <form action="{{ request()->routeIs('barang_masuk.create')?route('barang_masuk.store') : route('barang_masuk.update',$barang) }}" method="post" data-parsley-validate="true">
                    <div class="row">
                        @csrf
                        @if (request()->routeIs('barang_masuk.create'))
                        @method('post')
                        @else
                        @method('put')
                        @endif
                        <div class="col-lg-12 col-12 ">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-xs-12 form-group">
                                    <p>Kode Barcode</p>
                                    <input id="kode_barcode" type="text" name="barcode" class="form-control" value="{{ old('barcode',$barang_masuk->barcode??'') }}">
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                                    <label>Barang</label>
                                    <select name="barang_id" id="barang_id" class=" form-control  @error('barang_id') parsley-error @enderror" data-parsley-required="true" data-live-search="true" data-style="btn-warning">
                                        <option value="">Pilih Barang</option>
                                        @foreach($barangs as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg-6 col-md-12 col-xs-12">
                                    <p>Tanggal Masuk</p>
                                    <input id="" value="{{ old('tanggal',date('d-m-Y', strtotime($tanggal_libur->tanggal??date('d-m-Y')))) }}" name="tanggal" class="form-control flatpickr flatpickr-input active basicFlatpickr" type="text" placeholder="Select Date..">
                                </div>
                                <div class="col-lg-6 col-md-12 col-xs-12 form-group">
                                    <label>Supplier</label>
                                    <select name="supplier_id" id="supplier_id" class=" form-control  @error('supplier_id') parsley-error @enderror" data-parsley-required="true" data-live-search="true" data-style="btn-warning">
                                        <option value="">Pilih Supplier</option>
                                        @foreach($suppliers as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="alert alert-arrow-left alert-icon-left alert-light-primary mb-4" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg> ... </svg></button>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder-plus">
                                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                                    <line x1="12" y1="11" x2="12" y2="17"></line>
                                    <line x1="9" y1="14" x2="15" y2="14"></line>
                                </svg>
                                <div class="table-responsive">
                                    <table class="table table-sm mb-4">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th style="width: 10%;">Satuan</th>
                                                <th style="width: 20%; text-align: right;">Harga</th>
                                                <th style="width: 15%;">Qty</th>
                                                <th style="width: 20%; text-align: right;">Total</th>
                                                <th style="width: 10%;" class="text-center">#</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel_barang_masuk">
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="text-center" colspan="3"></td>
                                                <th class="text-center">Sub Total</td>
                                                <th style="text-align: right;"> <input type="text" class="form-control text-right" id="sub-total-harga" value="0" autocomplete="off" readonly /></td>
                                                <td class="text-center"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <button type="submit" class="mt-4 btn btn-success">Simpan Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('plugins/autonumeric/autoNumeric.js')}}"></script>
<script>
    var i = 0;
    $(".basicFlatpickr").flatpickr({
        dateFormat: "d-m-Y",
    });
    $('#barang_id').select2({
        placeholder: "Pilih Barang"
    });
    $('#supplier_id').select2({
        placeholder: "Pilih Supplier"
    });
    new AutoNumeric('#sub-total-harga', {
        modifyValueOnWheel: false,
        minimumValue: "0"
    });

    init_hitungan();

    function init_hitungan() {
        $(".hitungan").on("keyup change", function() {
            // console.log($(this).closest("tr").find(".harga").val());
            var harga = parseFloat($(this).closest("tr").find(".harga").val().split(',').join('') || 0);
            var diskon = 0;
            var ppn = 0;
            var qty = parseFloat($(this).closest("tr").find(".qty").val().split(',').join('') || 0);

            var harga_diskon = harga - (harga * diskon / 100);
            var harga_ppn = harga_diskon * ppn / 100;

            $(this).closest("tr").find(".total-harga").val(((harga_diskon + harga_ppn) * qty).toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));

            sub_total();
        });

        $(".hapus-barang").on("click", function(e) {
            e.preventDefault();
            $(this).closest("tr").remove();
            i -= 1;
            sub_total();
        })
    }

    function sub_total() {
        var sub_total = 0;
        var sub_total_ppn = 0;
        $('.total-harga').each(function(i, obj) {
            var harga = parseFloat($(this).closest("tr").find(".harga").val().split(',').join('') || 0);
            var diskon = 0;
            var ppn = 0;
            var qty = parseFloat($(this).closest("tr").find(".qty").val().split(',').join('') || 0);

            var harga_diskon = harga - (harga * diskon / 100);
            var harga_ppn = harga_diskon * ppn / 100;

            sub_total_ppn += harga_ppn * qty;
            sub_total += parseFloat(this.value.split(',').join('') || 0);
        });

        AutoNumeric.getAutoNumericElement('#sub-total-harga').set(sub_total);
    }
    var cekPilihBarang = false;

    function cekBarangTerpilih(id) {

        // $("#barang_id option:selected").data('barang')
        cekPilihBarang = false;
        for (let x = 0; x < i; x++) {

            if (id == document.getElementById("barang_id" + x).value) {

                console.log(document.getElementById("barang_id" + x).value + ' ' + x);
                console.log(document.getElementById("qty" + x).value);
                console.log(parseFloat(document.getElementById("harga" + x).value.split(',').join('')));
                document.getElementById("qty" + x).value = parseInt(document.getElementById("qty" + x).value) + 1;
                var total = parseFloat(document.getElementById("harga" + x).value.split(',').join('')) * (parseInt(document.getElementById("qty" + x).value));
                // document.getElementById("total_harga" + x).value =total;
                // console.log(total);
                AutoNumeric.getAutoNumericElement("#total_harga" + x).set(total);
                cekPilihBarang = true;
                sub_total();
                break;
            }
            // if (x % 2 == 0) {
            //     if (id == $("#table_barang_masuk" + x + " option:selected").data('barang')) {

            //     }
            // }
        }
    }

    function tambah_barang(barang_id) {
        cekBarangTerpilih(barang_id);
        console.log(cekPilihBarang);
        if (cekPilihBarang == false) {
            $.ajax({
                url: "/barang_masuk/tambahbarang/" + i,
                type: "GET",
                data: {
                    "barang_id": barang_id
                },
                async: false,
                success: function(data) {
                    // console.log(data);
                    $("#tabel_barang_masuk").append(data);
                    new AutoNumeric('#harga' + i, {
                        modifyValueOnWheel: false,
                        minimumValue: "0"
                    });
                    new AutoNumeric('#total_harga' + i, {
                        modifyValueOnWheel: false,
                        minimumValue: "0"
                    });
                    // new AutoNumeric('.currency' + i++, {
                    //     modifyValueOnWheel: false,
                    //     minimumValue: "0"
                    // });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tambah Barang',
                        text: xhr.responseJSON.message
                    })
                }
            });
            init_hitungan();
            i += 1;
        }

    }
    $('#barang_id').on('select2:select', function(data) {
        tambah_barang(data.params.data.id);
    });
</script>
@endpush