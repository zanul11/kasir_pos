@extends('layouts.app')

@push('style')

@endpush
@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 user-profile layout-spacing">
            <div class="widget-content widget-content-area">
                <div class="d-flex justify-content-between">
                    <!-- <h5 class="">Data {{ucwords($page_name)}}</h5> -->
                    <h3 class="">Form Data {{ucwords(str_replace('_', ' ',$page_name))}}</h3>
                    <a href="{{route('barang.index')}}" class="mt-2 edit-profile">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg></a>
                </div><br>
                <div class="row">
                    <div class="col-lg-12 col-12 ">
                        @isset($errors)
                        @if($errors->any())
                        <div class="alert alert-danger fade show">
                            <span class="close" data-dismiss="alert">×</span>
                            <strong>Oppss!</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @endisset
                        <form action="{{ request()->routeIs('barang.create')?route('barang.store') : route('barang.update',$barang) }}" method="post" data-parsley-validate="true">
                            @csrf
                            @if (request()->routeIs('barang.create'))
                            @method('post')
                            @else
                            @method('put')
                            @endif
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12 form-group">
                                    <p>Kode Barcode</p>
                                    <input id="barcode" type="text" name="barcode" class="form-control" value="{{ old('barcode',$barang->barcode??'') }}">
                                </div>
                                <div class="col-lg-12 col-md-12 col-xs-12 form-group">
                                    <p>Nama</p>
                                    <input id="nama" type="text" name="nama" class="form-control" value="{{ old('nama',$barang->nama??'') }}" required>
                                </div>
                                <div class="form-group col-lg-4 col-md-12 col-xs-12">
                                    <p>Satuan</p>
                                    <select class="form-control select2" data-live-search="false" name="satuan_id">
                                        @foreach ($satuan as $key => $dt)
                                        <option value="{{ $dt->id }}" {{ old('satuan_id',$barang->satuan_id??'')==$dt->id ? 'selected' : '' }}>
                                            {{ $dt->nama }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-12 col-xs-12 form-group">
                                    <p>Stok Minimal</p>
                                    <input id="stok_min" type="number" name="stok_min" class="form-control" value="{{ old('stok_min',$barang->stok_min??'') }}" required>
                                </div>
                                <div class="col-lg-4 col-md-12 col-xs-12 form-group">
                                    <p>Stok Awal</p>
                                    <input id="stok" type="number" name="stok" class="form-control" value="{{ old('stok',$barang->stok??'') }}" required>
                                </div>
                                <div class="col-lg-12 col-md-12 col-xs-12 form-group">
                                    <p>Harga Jual</p>
                                    <input id="harga_jual" type="number" name="harga_jual" class="form-control" value="{{ old('harga_jual',$barang->harga_jual??'') }}" required>
                                </div>
                                <div class="col-lg-12 col-md-12 col-xs-12 form-group">
                                    <p>Keterangan</p>
                                    <input id="keterangan" type="text" name="keterangan" class="form-control" value="{{ old('keterangan',$barang->keterangan??'') }}" required>
                                </div>
                            </div>
                            <button type="submit" class="mt-4 btn btn-primary">Simpan Data</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

</script>

@endpush