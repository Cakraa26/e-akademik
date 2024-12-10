@extends('layouts.app')

@section('title', __('message.editpengumuman'))

@push('style')
    <!-- CSS Libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <ul class="nav nav-pills">
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('dashboard') }}">{{ __('message.dashboard') }}</a></div>
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('pengumuman.index') }}">{{ __('message.pengumuman') }}</a>
                            </div>
                            <div class="breadcrumb-item">{{ __('message.edit') }}</div>
                        </div>
                    </ul>
                </div>
            </div>

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
                                <form id="form" action="{{ route('pengumuman.update', $pengumuman->pk) }}"
                                    method="POST" data-parsley-validate>
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-4">{{ __('message.tglbuat') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control" name="tglbuat"
                                                        value="{{ old('tglbuat', $pengumuman->tglbuat) }}" required
                                                        data-parsley-required-message="{{ __('message.tglbuatrequired') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-4">{{ __('message.tglberlakusampai') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control" name="tglsampai"
                                                        value="{{ old('tglsampai', $pengumuman->tglsampai) }}" required
                                                        data-parsley-required-message="{{ __('message.tglberlakurequired') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-2">{{ __('message.judul') }}</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="judul"
                                                        value="{{ old('judul', $pengumuman->judul) }}" required
                                                        data-parsley-required-message="{{ __('message.judulrequired') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row align-items-center">
                                                <label class="col-sm-2">{{ __('message.pengumuman') }}</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="catatan" required data-parsley-required-message="{{ __('message.ctnrequired') }}"
                                                        style="height: 100px">{{ old('catatan', $pengumuman->catatan) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row align-items-center mt-n3 mt-md-0">
                                        <label class="col-sm-2"></label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="aktif"
                                                    value="1"
                                                    {{ old('aktif', $pengumuman->aktif) == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label">Aktif</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <a class="btn btn-dark mr-2" href="{{ route('pengumuman.index') }}">
                                                <i class="fas fa-arrow-left mr-1"></i> {{ __('message.kembali') }}</a>
                                            <button type="submit" class="btn btn-primary">
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
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>

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
