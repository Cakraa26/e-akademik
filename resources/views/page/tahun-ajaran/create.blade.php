@extends('layouts.app')

@section('title', __('message.tambahtahunajaran'))

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
                                    href="{{ route('tahun-ajaran.index') }}">{{ __('message.thnajaran') }}</a>
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
                                <form id="form" action="{{ route('tahun-ajaran.store') }}" method="POST"
                                    data-parsley-validate>
                                    @csrf
                                    @method('POST')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">{{ __('message.nama') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" placeholder="{{ __('message.placeholdernm') }}"
                                                        class="form-control @error('nm') is-invalid @enderror"
                                                        name="nm" id="nm" value="{{ old('nm') }}" required
                                                        data-parsley-required-message="{{ __('message.nmrequired') }}">
                                                    @error('nm')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">{{ __('message.bulan1') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="month" class="form-control" name="bulan1" id="bulan1"
                                                        value="{{ old('bulan1') }}" required
                                                        data-parsley-required-message="{{ __('message.bln1required') }}">
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">{{ __('message.bulan2') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="month" class="form-control" name="bulan2" id="bulan2"
                                                        value="{{ old('bulan2') }}" required
                                                        data-parsley-required-message="{{ __('message.bln1required') }}">
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">{{ __('message.bulan3') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="month" class="form-control" name="bulan3" id="bulan3"
                                                        value="{{ old('bulan3') }}" required
                                                        data-parsley-required-message="{{ __('message.bln3required') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">{{ __('message.bulan4') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="month" class="form-control" name="bulan4" id="bulan3"
                                                        value="{{ old('bulan4') }}" required
                                                        data-parsley-required-message="{{ __('message.bln4required') }}">
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">{{ __('message.bulan5') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="month" class="form-control" name="bulan5" id="bulan5"
                                                        value="{{ old('bulan5') }}" required
                                                        data-parsley-required-message="{{ __('message.bln5required') }}">
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">{{ __('message.bulan6') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="month" class="form-control" name="bulan6" id="bulan6"
                                                        value="{{ old('bulan6') }}" required
                                                        data-parsley-required-message="{{ __('message.bln6required') }}">
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3"></label>
                                                <div class="col-sm-9">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="aktif"
                                                            name="aktif" value="1"
                                                            {{ old('aktif') == '1' ? 'checked' : '' }}>
                                                        <label class="form-check-label">{{ __('message.thnaktif') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="datetime-local" class="form-control" id="datemodified"
                                        name="datemodified"
                                        value="{{ old('datemodified', now()->format('Y-m-d\TH:i')) }}" hidden>

                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <a class="btn btn-dark mr-2" href="{{ route('tahun-ajaran.index') }}"> <i
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
