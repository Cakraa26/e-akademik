@extends('layouts.app')

@section('title', __('message.tambahfile'))

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
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('dashboard') }}">{{ __('message.dashboard') }}</a></div>
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('upload.file.index') }}">{{ __('message.uploadfile') }}</a>
                            </div>
                            <div class="breadcrumb-item">{{ __('message.tambah') }}</div>
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
                                <form id="form" enctype="multipart/form-data" action="{{ route('upload.file.store') }}"
                                    method="POST" data-parsley-validate>
                                    @csrf
                                    @method('POST')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-4 row align-items-center">
                                                <label for="nm" class="col-sm-3">{{ __('message.nama') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="nm" id="nm"
                                                        value="{{ old('nm') }}" required
                                                        data-parsley-required-message="{{ __('message.nmrequired') }}">
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label for="ctn" class="col-sm-3">{{ __('message.ctn') }}</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" name="ctn" id="ctn" required
                                                        data-parsley-required-message="{{ __('message.ctnrequired') }}" style="height: 107px">{{ old('ctn') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">{{ __('message.uploadfile') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="file" required
                                                        data-parsley-required-message="{{ __('message.filerequired') }}"
                                                        class="form-control" name="uploadFile"
                                                        accept="application/pdf, application/msword">
                                                </div>
                                            </div>
                                            <div class="mb-2 row align-items-center">
                                                <label for="alamat" class="col-sm-3">Status</label>
                                                <div class="col-md-8">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="status"
                                                            name="aktif" value="1" checked>
                                                        <label class="form-check-label" for="status">Aktif</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="datetime-local" class="form-control" id="datemodified" name="datemodified"
                                        value="{{ old('datemodified', now()->format('Y-m-d\TH:i')) }}" hidden>

                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <a class="btn btn-dark mr-1" href="{{ route('upload.file.index') }}">
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
