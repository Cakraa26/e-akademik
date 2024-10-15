@extends('layouts.app')

@section('title', __('message.editresiden'))

@push('style')
    <!-- CSS Libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('dashboard') }}">{{ __('message.dashboard') }}</a></div>
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('tingkat.residen.index') }}">{{ __('message.residen') }}</a>
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
                                <form id="form" action="{{ route('tingkat.residen.update', $residen->pk) }}"
                                    method="POST" data-parsley-validate>
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-4 row align-items-center">
                                                <label for="kode" class="col-sm-3">{{ __('message.kd') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text"
                                                        class="form-control  @error('kd') is-invalid @enderror"
                                                        name="kd" id="kode" value="{{ old('kd', $residen->kd) }}"
                                                        required
                                                        data-parsley-required-message="{{ __('message.kdrequired') }}">
                                                    @error('kd')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-4 row align-items-center">
                                                <label for="telepon"
                                                    class="col-sm-3">{{ __('message.namatahapan') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text"
                                                        class="form-control  @error('nm') is-invalid @enderror"
                                                        name="nm" id="nm" value="{{ old('nm', $residen->nm) }}"
                                                        required
                                                        data-parsley-required-message="{{ __('message.namatahapanrequired') }}">
                                                    @error('nm')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-4 row align-items-center">
                                                <label for="warna" class="col-sm-3">{{ __('message.warna') }}</label>
                                                <div class="col-sm-9">
                                                    <select
                                                        data-parsley-required-message="{{ __('message.warnarequired') }}"
                                                        required
                                                        class="form-select select2 @error('warna') is-invalid @enderror"
                                                        id="warna" name="warna">
                                                        <option value=""></option>
                                                        @foreach ($warna as $wrn)
                                                            <option value="{{ $wrn }}"
                                                                {{ old('warna', $residen->warna) == $wrn ? 'selected' : '' }}>
                                                                {{ $wrn }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('warna')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="darisemester"
                                                    class="col-sm-3">{{ __('message.drsemester') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="number"
                                                        class="form-control  @error('darisemester') is-invalid @enderror"
                                                        name="darisemester" id="darisemester"
                                                        value="{{ old('darisemester', $residen->darisemester) }}" required
                                                        data-parsley-required-message="{{ __('message.drsemesterrequired') }}">
                                                    @error('darisemester')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="sampaisemester"
                                                    class="col-sm-3">{{ __('message.btssemester') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="number"
                                                        class="form-control  @error('sampaisemester') is-invalid @enderror"
                                                        name="sampaisemester" id="sampaisemester"
                                                        value="{{ old('sampaisemester', $residen->sampaisemester) }}"
                                                        required
                                                        data-parsley-required-message="{{ __('message.btssemesterrequired') }}">
                                                    @error('sampaisemester')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="aktif"
                                                    id="inlineCheckbox1" {{ $residen->aktif == true ? 'checked' : '' }}
                                                    value="1">
                                                <label class="form-check-label"
                                                    for="inlineCheckbox1">{{ __('message.active') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="datetime-local" class="form-control" id="datemodified"
                                        name="datemodified"
                                        value="{{ old('datemodified', now()->format('Y-m-d\TH:i')) }}" hidden>

                                    <div class="row mt-2">
                                        <div class="col-12 d-flex justify-content-end">
                                            <a class="btn btn-dark load-btn mr-2"
                                                href="{{ route('tingkat.residen.index') }}">
                                                <i class="fas fa-arrow-left mr-2"></i> {{ __('message.kembali') }}</a>
                                            <button type="submit" id="submit-btn" class="btn btn-primary load-btn">
                                                {{ __('message.simpan') }} <i class="fas fa-save pl-2"></i>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/page/load-btn.js') }}"></script>


    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            $('#form').parsley({
                errorClass: 'is-invalid parsley-error',
                successClass: 'is-valid',
                errorsWrapper: '<span class="invalid-feedback"></span>',
                errorTemplate: '<div></div>',
            });
            $('#form2').parsley({
                errorClass: 'is-invalid parsley-error',
                successClass: 'is-valid',
                errorsWrapper: '<span class="invalid-feedback"></span>',
                errorTemplate: '<div></div>'
            });
            $('#form3').parsley({
                errorClass: 'is-invalid parsley-error',
                successClass: 'is-valid',
                errorsWrapper: '<span class="invalid-feedback"></span>',
                errorTemplate: '<div></div>'
            });
            $('#form4').parsley({
                errorClass: 'is-invalid parsley-error',
                successClass: 'is-valid',
                errorsWrapper: '<span class="invalid-feedback"></span>',
                errorTemplate: '<div></div>'
            });
        });
    </script>
@endpush
