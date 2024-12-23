@extends('layouts.app')

@section('title', __('message.editjadwal'))

@push('style')
    <!-- CSS Libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
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
                                    href="{{ route('jadwal.stase.index') }}">{{ __('message.jdwstase') }}</a>
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
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('message.residen') }}</label>
                        <h2 class="section-title2">{{ $residen->nm }}</h2>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <label class="form-label">{{ __('message.thnajaran') }}</label>
                        <h2 class="section-title2">{{ $residen->tahunajaran->nm }}</h2>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('message.tingkat') }}</label>
                        <h2 class="section-title2">{{ $residen->tingkat->kd }}</h2>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <label class="form-label">Semester</label>
                        <h2 class="section-title2">{{ $residen->semester }}</h2>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="form" action="{{ route('jadwal.stase.store', $residen->pk) }}"
                                    method="POST" data-parsley-validate>
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">{{ __('message.bulan1') }}</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control select2" name="stasefk1" id="stasefk1">
                                                        <option value=""></option>
                                                        @foreach ($stase as $s)
                                                            <option value="{{ $s->pk }}"
                                                                {{ optional($residen->jadwal->firstWhere('bulan', date('m', strtotime($bulan['bulan1']))))->stasefk == $s->pk ? 'selected' : '' }}>
                                                                {{ $s->nm }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">{{ __('message.bulan2') }}</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control select2" name="stasefk2" id="stasefk2">
                                                        <option value=""></option>
                                                        @foreach ($stase as $s)
                                                            <option value="{{ $s->pk }}"
                                                                {{ optional($residen->jadwal->firstWhere('bulan', date('m', strtotime($bulan['bulan2']))))->stasefk == $s->pk ? 'selected' : '' }}>
                                                                {{ $s->nm }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">{{ __('message.bulan3') }}</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control select2" name="stasefk3" id="stasefk3">
                                                        <option value=""></option>
                                                        @foreach ($stase as $s)
                                                            <option value="{{ $s->pk }}"
                                                                {{ optional($residen->jadwal->firstWhere('bulan', date('m', strtotime($bulan['bulan3']))))->stasefk == $s->pk ? 'selected' : '' }}>
                                                                {{ $s->nm }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">{{ __('message.bulan4') }}</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control select2" name="stasefk4" id="stasefk4">
                                                        <option value=""></option>
                                                        @foreach ($stase as $s)
                                                            <option value="{{ $s->pk }}"
                                                                {{ optional($residen->jadwal->firstWhere('bulan', date('m', strtotime($bulan['bulan4']))))->stasefk == $s->pk ? 'selected' : '' }}>
                                                                {{ $s->nm }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">{{ __('message.bulan5') }}</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control select2" name="stasefk5" id="stasefk5">
                                                        <option value=""></option>
                                                        @foreach ($stase as $s)
                                                            <option value="{{ $s->pk }}"
                                                                {{ optional($residen->jadwal->firstWhere('bulan', date('m', strtotime($bulan['bulan5']))))->stasefk == $s->pk ? 'selected' : '' }}>
                                                                {{ $s->nm }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">{{ __('message.bulan6') }}</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control select2" name="stasefk6" id="stasefk6">
                                                        <option value=""></option>
                                                        @foreach ($stase as $s)
                                                            <option value="{{ $s->pk }}"
                                                                {{ optional($residen->jadwal->firstWhere('bulan', date('m', strtotime($bulan['bulan6']))))->stasefk == $s->pk ? 'selected' : '' }}>
                                                                {{ $s->nm }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <a class="btn btn-dark mr-1" href="{{ route('jadwal.stase.index') }}"> <i
                                                    class="fas fa-arrow-left mr-1"></i> {{ __('message.kembali') }}</a>
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
                errorTemplate: '<div></div>'
            })
        });
    </script>
@endpush
