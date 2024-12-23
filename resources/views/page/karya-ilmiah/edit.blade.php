@extends('layouts.app')

@section('title', __('message.editkaryailmiah'))

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
                                    href="{{ route('karya-ilmiah.index') }}">{{ __('message.mstkarya') }}</a>
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
                                <form id="form" action="{{ route('karya-ilmiah.update', $karya->pk) }}" method="POST"
                                    data-parsley-validate>
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="telepon" class="col-sm-4">{{ __('message.nama') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="text"
                                                        class="form-control  @error('nm') is-invalid @enderror"
                                                        name="nm" id="nm" value="{{ old('nm', $karya->nm) }}"
                                                        required
                                                        data-parsley-required-message="{{ __('message.nmrequired') }}">
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label for="telepon"
                                                    class="col-sm-4">{{ __('message.btssemester') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="text"
                                                        class="form-control  @error('sampaisemester') is-invalid @enderror"
                                                        name="sampaisemester" id="sampaisemester"
                                                        value="{{ old('sampaisemester', $karya->sampaisemester) }}" required
                                                        data-parsley-required-message="{{ __('message.btssemesterrequired') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="telepon"
                                                    class="col-sm-4">{{ __('message.drsemester') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="text"
                                                        class="form-control  @error('darisemester') is-invalid @enderror"
                                                        name="darisemester" id="darisemester"
                                                        value="{{ old('darisemester', $karya->darisemester) }}" required
                                                        data-parsley-required-message="{{ __('message.drsemesterrequired') }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3 align-items-center">
                                                <div class="col-md-4">
                                                    <label class="form-label">Status</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="status"
                                                            name="aktif" value="1"
                                                            {{ old('aktif', $karya->aktif) == '1' ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="status">{{ __('message.active') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <a class="btn btn-dark mr-1" href="{{ route('karya-ilmiah.index') }}">
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
