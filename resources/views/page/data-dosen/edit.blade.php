@extends('layouts.app')

@section('title', 'Edit Dosen')

@push('style')
    <!-- CSS Libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.css" rel="stylesheet">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <ul class="nav nav-pills">
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                            <div class="breadcrumb-item active"><a href="{{ route('data.dosen.index') }}">Data Dosen</a>
                            </div>
                            <div class="breadcrumb-item">Edit</div>
                        </div>
                    </ul>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible show fade" role="alert">
                    <strong>Sukses!</strong> {{ session('success') }}
                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible show fade" role="alert">
                    <strong>Error!</strong> {{ session('error') }}
                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif

            <div class="section-body">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="form" action="{{ route('data.dosen.update', $dosen->pk) }}" method="POST"
                                    data-parsley-validate>
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="nama" class="col-sm-3">Nama</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="nm" id="nm"
                                                        value="{{ old('nm', $dosen->nm) }}" required
                                                        data-parsley-required-message="Nama wajib diisi.">
                                                </div>
                                            </div>

                                            <div class="mb-4 row align-items-center">
                                                <label for="telepon" class="col-sm-3">No. Telepon</label>
                                                <div class="col-sm-9">
                                                    <input type="tel"
                                                        class="form-control  @error('tlp') is-invalid @enderror"
                                                        name="tlp" id="tlp" value="{{ old('tlp', $dosen->tlp) }}" required
                                                        data-parsley-required-message="No. Telepon wajib diisi.">
                                                    @error('tlp')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label for="alamat" class="col-sm-3">Alamat</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" name="alamat" id="alamat" required
                                                        data-parsley-required-message="Alamat wajib diisi." style="height: 107px">{{ old('alamat', $dosen->alamat) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label for="kota" class="col-sm-3">Tgl. Lahir</label>
                                                <div class="col-sm-9">
                                                    <input type="date" class="form-control" name="tgllahir"
                                                        id="tgllahir" value="{{ old('tgllahir', $dosen->tgllahir) }}"
                                                        required data-parsley-required-message="Tgl. Lahir wajib diisi.">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="jabatan" class="col-sm-3">NIP</label>
                                                <div class="col-sm-9">
                                                    <input type="text"
                                                        class="form-control @error('nip') is-invalid @enderror"
                                                        name="nip" id="nip" value="{{ old('nip', $dosen->nip) }}" required
                                                        data-parsley-required-message="NIP wajib diisi.">
                                                    @error('nip')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label for="pekerjaan" class="col-sm-3">Divisi</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="divisi" id="divisi"
                                                        value="{{ old('divisi', $dosen->divisi) }}" required
                                                        data-parsley-required-message="Divisi wajib diisi.">
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label for="perusahaan" class="col-sm-3">Pangkat</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="pangkat"
                                                        id="pangkat" value="{{ old('pangkat', $dosen->pangkat) }}"
                                                        required data-parsley-required-message="Pangkat wajib diisi.">
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label for="perusahaan" class="col-sm-3">Golongan</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="golongan"
                                                        id="golongan" value="{{ old('golongan', $dosen->golongan) }}"
                                                        required data-parsley-required-message="Golongan wajib diisi.">
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label for="perusahaan" class="col-sm-3">Spesialias</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="spesialis"
                                                        id="spesialis" value="{{ old('spesialis', $dosen->spesialis) }}"
                                                        required data-parsley-required-message="Spesialis wajib diisi.">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="datetime-local" class="form-control" id="datemodified"
                                        name="datemodified"
                                        value="{{ old('datemodified', now()->format('Y-m-d\TH:i')) }}" hidden>

                                    <div class="row mt-2">
                                        <div class="col-12 d-flex justify-content-end">
                                            <a class="btn btn-dark mr-2" href="{{ route('data.dosen.index') }}"> <i
                                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                                            <button type="submit" class="btn btn-primary">
                                                Simpan <i class="fas fa-save pl-1"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>

    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            $('#form').parsley({
                errorClass: 'is-invalid parsley-error',
                successClass: 'is-valid',
                errorsWrapper: '<span class="invalid-feedback"></span>',
                errorTemplate: '<div></div>'
            })
        });
    </script>
@endpush
