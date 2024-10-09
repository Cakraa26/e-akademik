@extends('layouts.app')

@section('title', __('message.editdosen'))

@push('style')
    <!-- CSS Libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/load-btn.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <ul class="nav nav-pills">
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('message.dashboard') }}</a></div>
                            <div class="breadcrumb-item active"><a href="{{ route('data.dosen.index') }}">{{ __('message.datadosen') }}</a>
                            </div>
                            <div class="breadcrumb-item">{{ __('message.edit') }}</div>
                        </div>
                    </ul>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible show fade" role="alert">
                    <strong>{{ __('message.success') }}!</strong> {{ session('success') }}
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
                                                <label for="nama" class="col-sm-3">{{ __('message.nama') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="nm" id="nm"
                                                        value="{{ old('nm', $dosen->nm) }}" required
                                                        data-parsley-required-message="{{ __('message.nmrequired') }}">
                                                </div>
                                            </div>

                                            <div class="mb-4 row align-items-center">
                                                <label for="telepon" class="col-sm-3">{{ __('message.tlp') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="tel"
                                                        class="form-control  @error('tlp') is-invalid @enderror"
                                                        name="tlp" id="tlp" value="{{ old('tlp', $dosen->tlp) }}" required
                                                        data-parsley-required-message="{{ __('message.tlprequired') }}">
                                                    @error('tlp')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label for="alamat" class="col-sm-3">{{ __('message.alamat') }}</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" name="alamat" id="alamat" required
                                                        data-parsley-required-message="{{ __('message.alamatrequired') }}" style="height: 107px">{{ old('alamat', $dosen->alamat) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label for="kota" class="col-sm-3">{{ __('message.tgllahir') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="date" class="form-control" name="tgllahir"
                                                        id="tgllahir" value="{{ old('tgllahir', $dosen->tgllahir) }}"
                                                        required data-parsley-required-message="{{ __('message.tgllahirrequired') }}">
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
                                                        data-parsley-required-message="{{ __('message.niprequired') }}">
                                                    @error('nip')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label for="pekerjaan" class="col-sm-3">{{ __('message.divisi') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="divisi" id="divisi"
                                                        value="{{ old('divisi', $dosen->divisi) }}" required
                                                        data-parsley-required-message="{{ __('message.divisirequired') }}">
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label for="perusahaan" class="col-sm-3">{{ __('message.pangkat') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="pangkat"
                                                        id="pangkat" value="{{ old('pangkat', $dosen->pangkat) }}"
                                                        required data-parsley-required-message="{{ __('message.pangkatrequired') }}">
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label for="perusahaan" class="col-sm-3">{{ __('message.golongan') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="golongan"
                                                        id="golongan" value="{{ old('golongan', $dosen->golongan) }}"
                                                        required data-parsley-required-message="{{ __('message.golrequired') }}">
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label for="perusahaan" class="col-sm-3">{{ __('message.spesialis') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="spesialis"
                                                        id="spesialis" value="{{ old('spesialis', $dosen->spesialis) }}"
                                                        required data-parsley-required-message="{{ __('message.spesialisrequired') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="datetime-local" class="form-control" id="datemodified"
                                        name="datemodified"
                                        value="{{ old('datemodified', now()->format('Y-m-d\TH:i')) }}" hidden>

                                    <div class="row mt-2">
                                        <div class="col-12 d-flex justify-content-end">
                                            <a class="btn btn-dark load-btn mr-2" href="{{ route('data.dosen.index') }}"> <i
                                                    class="fas fa-arrow-left mr-1"></i> {{ __('message.kembali') }}</a>
                                            <button type="submit" class="btn btn-primary load-btn">
                                                {{ __('message.simpan') }} <i class="fas fa-save pl-1"></i>
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
    <script src="{{ asset('js/page/load-btn.js') }}"></script>

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
