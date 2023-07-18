<div>
    <div class="row">
        <div class="col-lg-12 col-12 ">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-xs-12 form-group">
                    <p>Kode Barcode</p>
                    <input id="barcode" type="text" name="barcode" class="form-control" value="{{ old('barcode',$barang_masuk->barcode??'') }}">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                    <label>Barang</label>
                    <select name="barang_id" id="barang_id" class=" form-control  @error('barang_id') parsley-error @enderror" data-parsley-required="true" data-live-search="true" data-style="btn-warning" wire:model="pegawaiId">
                        <option value="">Pilih Barang</option>
                        @foreach($barangs as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-6 col-md-12 col-xs-12">
                    <p>Tanggal Masuk</p>
                    <input id="" value="{{ old('tgl_libur',date('d-m-Y', strtotime($tanggal_libur->tgl_libur??date('d-m-Y')))) }}" name="tgl_libur" class="form-control flatpickr flatpickr-input active basicFlatpickr" type="text" placeholder="Select Date..">
                </div>
                <div class="col-lg-6 col-md-12 col-xs-12 form-group">
                    <p>Supplier</p>
                    <input id="nama" type="text" name="nama" class="form-control" value="{{ old('nama',$barang_masuk->nama??'') }}" required>
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
                    <table class="table mb-4">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Nama Barang</th>
                                <th style="width: 10%;">Satuan</th>
                                <th style="width: 20%; text-align: right;">Harga</th>
                                <th style="width: 10%;">Qty</th>
                                <th style="width: 20%; text-align: right;">Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($barang_masuk as $key => $item)
                            <tr>
                                <td class="text-center">{{$key+1}}</td>
                                <td class="text-primary">{{$item['nama']}}</td>
                                <td>{{$item['satuan']}}</td>
                                <td style="text-align: right;">
                                    <input type="text" class="form-control currency">
                                </td>
                                <td><input min="1" value="{{$item['qty']}}" class="form-control" type="number"></td>
                                <td style="text-align: right;"><span class=" shadow-none badge outline-badge-primary">{{number_format($item['harga']*$item['qty'])}}</span></td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="text-center" colspan="4"></td>
                                <th class="text-center">Sub Total</td>
                                <th style="text-align: right;"><span class=" shadow-none badge outline-badge-danger">{{number_format($item['harga']*$item['qty'])}}</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



@push('scripts')

<script>
    $('#barang_id').on('select2:select', function(data) {
        @this.set('barangId', data.params.data.id);
    });
    Livewire.on('reinit', () => {
        // console.log(@this.barangId);
        AutoNumeric.multiple('.currency', {
            modifyValueOnWheel: false,
            minimumValue: "0"
        });
        $('#barang_id').select2({
            placeholder: 'Pilih Barang!'
        });
    });
    // // $('#location_id').on('change', function(e) {
    // //     console.log(e);
    // //     Livewire.emit('ubahLokasi');
    // //     // Livewire.on('ubahLoklasi', () => {
    // //     //     $('#pegawai_id').select2();
    // //     // });
    // // });
</script>

@endpush