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
                    <h3 class="">Form {{request()->routeIs('barang_keluar.create')?'Penjulan':'Retur Penjualan'}}</h3>
                    <a href="{{route('barang_keluar.index')}}" class="mt-2 edit-profile">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg></a>
                </div><br>
                <form action="{{ request()->routeIs('barang_keluar.create')?route('barang_keluar.store') : route('barang_keluar.update',$barang_keluar) }}" method="post" data-parsley-validate="true">
                    <div class="row">
                        @csrf
                        @if (request()->routeIs('barang_keluar.create'))
                        @method('post')
                        @else
                        @method('put')
                        @endif
                        <div class="col-lg-12 col-12 ">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-xs-12 form-group">
                                    <p>Kode Barcode</p>
                                    <input id="kode_barcode" type="text" name="barcode" class="form-control" value="{{ old('barcode',$barang_keluar->barcode??'') }}">
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
                                <div class="form-group col-lg-4 col-md-12 col-xs-12">
                                    <p>Tanggal Penjualan</p>
                                    <input id="" value="{{ old('tanggal',date('d-m-Y', strtotime($barang_keluar->tanggal??date('d-m-Y')))) }}" name="tanggal" class="form-control flatpickr flatpickr-input active basicFlatpickr" type="text" placeholder="Select Date..">
                                </div>
                                <div class="col-lg-4 col-md-12 col-xs-12 form-group">
                                    <p>Keterangan</p>
                                    <input id="keterangan" type="text" name="keterangan" class="form-control" value="{{ old('keterangan',$barang_keluar->keterangan??'') }}">
                                </div>
                                <div class="col-lg-4 col-md-12 col-xs-12 form-group">
                                    <label>Pelanggan</label>
                                    <select name="pelanggan_id" id="pelanggan_id" class=" form-control  @error('pelanggan_id') parsley-error @enderror" data-parsley-required="true" data-live-search="true" data-style="btn-warning">
                                        <option value="">Pilih Pelanggan</option>
                                        @foreach($pelanggans as $item)
                                        <option value="{{ $item->id }}" {{ old('pelanggan_id',$barang_keluar->pelanggan_id??'')==$item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
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
                                                <th style="width: 10%;">Qty</th>
                                                <th style="width: 20%; text-align: right;">Diskon</th>
                                                <th style="width: 20%; text-align: right;">Total</th>
                                                <th style="width: 5%;" style="text-align: right;">#</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel_barang_keluar">
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="text-center" colspan="4"></td>
                                                <th class="text-center">Sub Total</td>
                                                <th style="text-align: right;"> <input type="text" class="form-control text-right" id="sub-total-harga" value="0" autocomplete="off" readonly /></td>
                                                <td class="text-center"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <button type="submit" class="mt-4 btn btn-danger">Simpan Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@if (Session::has('kwitansi'))
<div class="modal fade" id="modal-kwitansi" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Kwitansi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div id="modal-detail"></div>
            <!-- <div class="modal-body">
                <p class="modal-text">Mauris mi tellus, pharetra vel mattis sed, tempus ultrices eros. Phasellus egestas sit amet velit sed luctus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse potenti. Vivamus ultrices sed urna ac pulvinar. Ut sit amet ullamcorper mi.</p>
            </div> -->

        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')

<script src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('plugins/autonumeric/autoNumeric.js')}}"></script>
<script>
    $("#modal-detail").load("{{ Session::get('kwitansi') }}");
    $('#modal-kwitansi').modal('show');
    $('#modal-kwitansi').on('hidden.bs.modal', function() {
        if (!$('#modal-kwitansi').hasClass('no-reload')) {
            location.reload();
        }
    });
    var i = 0;
    $(".basicFlatpickr").flatpickr({
        dateFormat: "d-m-Y",
    });
    $('#barang_id').select2({
        placeholder: "Pilih Barang"
    });
    $('#pelanggan_id').select2({
        placeholder: "Pilih Pelanggan"
    });
    new AutoNumeric('#sub-total-harga', {
        modifyValueOnWheel: false,
        minimumValue: "0"
    });

    function decodeHtml(html) {
        var txt = document.createElement("textarea");
        txt.innerHTML = html;
        return txt.value;
    }
    var barang = JSON.parse(decodeHtml("{{ json_encode($barang_keluar->barangKeluarDetail??[]) }}"));
    barang.forEach(brg => {
        tambah_barang(brg['barang_id'], brg);
    });

    function hapus_barang(id) {
        $("#" + id).remove();
        sub_total();
        console.log(i);
    }

    function total_harga_barang(id) {
        console.log(id);
        var qty = $("#qty" + id).val() || 0;
        var harga = parseFloat($("#harga" + id).val().split(',').join('') || 0);
        var diskon = parseFloat($("#diskon" + id).val().split(',').join('') || 0);
        AutoNumeric.getAutoNumericElement('#total_harga' + id).set((harga - diskon) * (qty ? qty : 0));
        sub_total();
    }

    function sub_total() {
        var sub_total = 0;
        $('.total-harga-barang').each(function(i, obj) {
            var harga = parseFloat($(this).closest("tr").find(".harga").val().split(',').join('') || 0);
            var diskon = parseFloat($(this).closest("tr").find(".diskon").val().split(',').join('') || 0);
            var qty = parseFloat($(this).closest("tr").find(".qty").val().split(',').join('') || 0);
            var harga_diskon = harga - diskon;
            sub_total += (harga_diskon * qty);
        });

        AutoNumeric.getAutoNumericElement('#sub-total-harga').set(sub_total);
    }
    var cekPilihBarang = false;

    function cekBarangTerpilih(id) {
        cekPilihBarang = false;
        for (let x = 0; x < i; x++) {
            if (x % 2 == 0) {
                if (document.getElementById("barang_id" + x) && document.getElementById("barang_id" + x).value) {
                    if (id == document.getElementById("barang_id" + x).value) {
                        document.getElementById("qty" + x).value = parseInt(document.getElementById("qty" + x).value) + 1;
                        var total = (parseFloat(document.getElementById("harga" + x).value.split(',').join('')) - parseFloat(document.getElementById("diskon" + x).value.split(',').join(''))) * (parseInt(document.getElementById("qty" + x).value));
                        AutoNumeric.getAutoNumericElement("#total_harga" + x).set(total);
                        cekPilihBarang = true;
                        sub_total();
                        break;
                    }
                }
            }

        }
    }

    function tambah_barang(barang_id, barang_keluar) {
        cekBarangTerpilih(barang_id);
        if (cekPilihBarang == false) {
            $.ajax({
                url: "/barang_keluar/tambahbarang/" + i,
                type: "GET",
                data: {
                    "barang_id": barang_id,
                    "barang_keluar": barang_keluar
                },
                async: false,
                success: function(data) {
                    $("#tabel_barang_keluar").append(data);
                    if (AutoNumeric.getAutoNumericElement('#harga' + i) === null) {
                        new AutoNumeric('#harga' + i, {
                            modifyValueOnWheel: false,
                            minimumValue: "0"
                        });
                    }
                    if (AutoNumeric.getAutoNumericElement('#diskon' + i) === null) {
                        new AutoNumeric('#diskon' + i, {
                            modifyValueOnWheel: false,
                            minimumValue: "0"
                        });
                    }
                    if (AutoNumeric.getAutoNumericElement('#total_harga' + i) === null) {
                        new AutoNumeric('#total_harga' + i++, {
                            modifyValueOnWheel: false,
                            minimumValue: "0"
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tambah Barang',
                        text: xhr.responseJSON.message
                    })
                }
            });
            i += 1;
            sub_total();
        }

    }
    $('#barang_id').on('select2:select', function(data) {
        tambah_barang(data.params.data.id, null);
    });
</script>
@endpush