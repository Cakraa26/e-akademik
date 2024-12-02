@extends('layouts.app')

@section('title', __('message.tambahtingkat'))

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
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
                                    href="{{ route('tingkat.residen.index') }}">{{ __('message.tingkat') }}</a>
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
                                <form id="form" action="{{ route('tingkat.residen.store') }}" method="POST"
                                    data-parsley-validate>
                                    @csrf
                                    @method('POST')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">{{ __('message.kd') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text"
                                                        class="form-control @error('kd') is-invalid @enderror"
                                                        name="kd" value="{{ old('kd') }}" required
                                                        data-parsley-required-message="{{ __('message.kdrequired') }}">
                                                    @error('kd')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">{{ __('message.nama') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="nm"
                                                        value="{{ old('nm') }}" required
                                                        data-parsley-required-message="{{ __('message.nmrequired') }}">
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">{{ __('message.warna') }}</label>
                                                <div class="col-sm-9">
                                                    <select class="form-select select2" name="warna" required
                                                        data-parsley-required-message="{{ __('message.warnarequired') }}">
                                                        <option value=""></option>
                                                        @foreach ($warna as $wrn)
                                                            <option value="{{ $wrn }}"
                                                                {{ old('warna') == $wrn ? 'selected' : '' }}>
                                                                {{ $wrn }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-4">{{ __('message.btssemester') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" name="sampaisemester"
                                                        value="{{ old('sampaisemester') }}" required
                                                        data-parsley-required-message="{{ __('message.btssemesterrequired') }}">
                                                </div>
                                            </div>
                                            <div class="mb-3 row align-items-center">
                                                <label class="col-sm-4">{{ __('message.drsemester') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" name="darisemester"
                                                        value="{{ old('darisemester') }}" required
                                                        data-parsley-required-message="{{ __('message.drsemesterrequired') }}">
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-4"></label>
                                                <div class="col-sm-8">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name="aktif"
                                                            {{ old('aktif') ? 'checked' : '' }} value="1">
                                                        <label class="form-check-label">{{ __('message.active') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="datetime-local" class="form-control" id="datemodified" name="datemodified"
                                        value="{{ old('datemodified', now()->format('Y-m-d\TH:i')) }}" hidden>

                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <a class="btn btn-dark mr-2" href="{{ route('tingkat.residen.index') }}">
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
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            $('#form').parsley({
                errorClass: 'is-invalid parsley-error',
                successClass: 'is-valid',
                errorsWrapper: '<span class="invalid-feedback"></span>',
                errorTemplate: '<div></div>',
            });
        });
    </script>
@endpush
