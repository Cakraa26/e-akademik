@extends('layouts.app')

@section('title', __('message.editabsen'))

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
                                    href="{{ route('absensi.index') }}">{{ __('message.absensi') }}</a>
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
                                <form id="form" action="{{ route('absensi.update', $absen->pk) }}" method="POST"
                                    data-parsley-validate>
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">{{ __('message.nama') }}</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control select2" id="residenfk" name="residenfk" required
                                                    data-parsley-required-message="{{ __('message.nmrequired') }}">
                                                        <option value=""></option>
                                                        @foreach ($residen as $r)
                                                            <option value="{{ $r->pk }}"
                                                                {{ old('residenfk', $absen->residenfk) == $r->pk ? 'selected' : '' }}>
                                                                {{ $r->nm }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">Check-In</label>
                                                <div class="col-sm-9">
                                                    <input type="datetime-local" class="form-control" name="check_in"
                                                        id="check_in" value="{{ old('check_in', $absen->check_in) }}" required
                                                        data-parsley-required-message="{{ __('message.checkinrequired') }}">
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label for="ctn" class="col-sm-3">{{ __('message.ctn') }}</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" name="ctn" id="ctn"
                                                        data-parsley-required-message="{{ __('message.ctnrequired') }}" style="height: 100px">{{ old('ctn', $absen->ctn) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">{{ __('message.koordinat') }}</label>
                                                <div class="col-sm-9 d-flex align-items-center">
                                                    <div class="col-10 pr-1 pl-0">
                                                        <input type="text" name="coordinates" id="coordinates"
                                                            class="form-control" value="{{ old('coordinates', $absen->loc_in) }}" readonly>
                                                    </div>
                                                    <div class="col-2 pl-1">
                                                        <button type="button" class="btn btn-secondary"
                                                            id="get-location">Get</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">Check-Out</label>
                                                <div class="col-sm-9">
                                                    <input type="datetime-local" class="form-control" name="check_out"
                                                        id="check_out" value="{{ old('check_out', $absen->check_out) }}" required
                                                        data-parsley-required-message="{{ __('message.checkoutrequired') }}">
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3 mr-3 d-none d-sm-block">&nbsp;</label>
                                                <div class="form-check ml-3 ml-md-0">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="alpa" value="1"
                                                        {{ old('alpa', $absen->alpa) == '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ __('message.alpa') }}
                                                        / {{ __('message.tanpaabsen') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <a class="btn btn-dark mr-2" href="{{ route('absensi.index') }}">
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
                errorTemplate: '<div></div>'
            })
        });
    </script>

    <script>
        document.getElementById('get-location').addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    const coordinates = latitude + ',' + longitude;

                    document.getElementById('coordinates').value = coordinates;
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        });
    </script>
@endpush
