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
                    <a href="{{route('supplier.index')}}" class="mt-2 edit-profile">
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


                        <form action="{{ request()->routeIs('supplier.create')?route('supplier.store') : route('supplier.update',$supplier) }}" method="post" data-parsley-validate="true">
                            @csrf
                            @if (request()->routeIs('supplier.create'))
                            @method('post')
                            @else
                            @method('put')
                            @endif
                            <div class="form-group">
                                <p>Nama</p>
                                <input id="nama" type="text" name="nama" class="form-control" value="{{ old('nama',$supplier->nama??'') }}" required>
                            </div>
                            <div class="form-group">
                                <p>Alamat</p>
                                <input id="alamat" type="text" name="alamat" class="form-control" value="{{ old('alamat',$supplier->alamat??'') }}" required>
                            </div>
                            <div class="form-group">
                                <p>Kontak</p>
                                <input id="kontak" type="text" name="kontak" class="form-control" value="{{ old('kontak',$supplier->kontak??'') }}" required>
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